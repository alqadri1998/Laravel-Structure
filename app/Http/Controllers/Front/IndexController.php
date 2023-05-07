<?php

namespace App\Http\Controllers\Front;


use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Jobs\SendEmail;
use App\Models\Attribute;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Catalog;
use App\Models\Category;
use App\Models\Logo;
use App\Models\Origin;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Promotion;
use App\Models\Service;
use App\Models\Slider;
use App\Traits\EMails;
use App\Traits\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Util\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use function GuzzleHttp\Psr7\str;

class IndexController extends Controller
{
    use Users;

    public $branch;
    public $category;
    public $product;
    public $brand;
    public $promotion;
    public $attribute;

    public $brands = [];
    public $origins = [];
    public $allProperties = [];
    public $attributes = [];
    public $categories = [];
    public $promotions = [];

    public function __construct(Branch $branch, Category $category, Product $product, Brand $brand, Promotion $promotion, Attribute $attribute)
    {
        parent::__construct();
        $this->branch = $branch;
        $this->category = $category;
        $this->product = $product;
        $this->brand = $brand;
        $this->promotion = $promotion;
        $this->attribute = $attribute;
    }

    public function index()
    {
        $favorites = function ($favorites) {
            if (auth()->user() !== null) {
                $favorites->where('user_id', auth()->user()->id);
            }
        };
        $relations = ['languages', 'favorites' => $favorites, 'attributes'];
        if (!auth()->user()) {
            $relations = ['languages'];
        }

        $products = Product::whereHas('languages')->whereHas('categories')->with(['languages', 'attributes'])->where('type', 'product')->orderBy('created_at', 'DESC')->limit(8)->get();
        $this->setTranslations($products, 'languages', ['attributes' => 'languages']);

        $chooseUS = Page::whereHas('languages')->with('languages')->where('slug', config('settings.why_choose_us'))->get();
        $this->setTranslations($chooseUS);

        $services = Service::whereHas('languages')->with('languages')->where('type', '!=', 'repair')->latest()->paginate(6);
        $this->setTranslations($services);

        $servicePackages = Product::whereHas('languages')->where('type', 'package')->latest()->limit(3)->get();
        $this->setTranslations($servicePackages);

        $brands = Brand::whereHas('languages')->with('languages')->latest()->get();
        $this->setTranslations($brands);


        $sliders = Slider::latest()->get();

        $promotions = $this->promotion->getPromotions();

        $dateTime = $this->getDateTime();
//        return $products;
        return view('front.home.index', [
            'servicePackages' => $servicePackages,
            'products' => $products,
            'services' => $services,
            'brands' => $brands,
            'logos' => Logo::get(),
            'dates' => $dateTime['dates'],
            'times' => $dateTime['times'],
            'whyChooseUs' => $chooseUS->first(),
            'sliders' => $sliders,
            'promotions' => $promotions
        ]);
    }

    public function pages($slug)
    {
        $pageData = Page::whereHas('languages')->with('languages')->where('slug', $slug)->get();
        $this->setTranslations($pageData);
        $pageData = $pageData->first();
        $this->breadcrumbTitle = __($pageData->translation->title);
        $this->breadcrumbs['javascript: {};'] = ['title' => __($pageData->translation->title)];
        if ($slug !== 'about-us') {
            return view('front.home.terms-and-conditions', ['page' => $pageData]);
        }
        return view('front.home.pages', ['page' => $pageData]);

    }

    public function changeCurrency($curency)
    {
//        dd( cache('CURRENCIES', []));
        $currencyId = config('app.currencies.' . $curency, 'AED');
//        dd($currencyId);
        if (array_key_exists($currencyId, cache('CURRENCIES', []))) {
            session()->put('CURRENCY_ID', $currencyId, 0);
        }
//        dd(cache('CURRENCIES', []));
        return redirect()->back();
    }

    public function contactUs(Request $request)
    {
        $this->breadcrumbTitle = __('Contact Us');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Contact Us')];
        return view('front.home.contact');

    }

    public function contactEmail(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
//   'subject' => 'required',
            'message_text' => 'required',
        ]);

        $data = $request->all();
        $data['subject'] = __('Contact Us Message From' . config('settings.company_name') . 'Website');
        $data['receiver_email'] = config('settings.email');
        $data['receiver_name'] = 'TT';
        $data['sender_name'] = config('app.name');
        $data['sender_email'] = $data['email'];

//        SendEmail::dispatch($data,'emails.contact_us', $data['subject'],$data['receiver_email'], $data['sender_email']);
//
        $email = $this->sendMail($data, 'emails.contact_us', $data['subject'], $data['receiver_email'], $data['sender_email']);

        return redirect()->back()->with('status', __('Contact Email Sent Successfully'));
    }

    public function emailVerification()
    {
        if (\Auth::user()) {
            if (\Auth::user()->is_verified == 0) {
                $this->breadcrumbTitle = __('Email Verification');
                $this->breadcrumbs['javascript: {};'] = ['title' => __('Email Verification')];
                return view('front.auth.email-verify');
            } else {
                return redirect()->back()->with('error', __('You Are Already Verified'));
            }

        }
//        return redirect()->back();
    }

    /**
     * Check the submitted verification code and verify the user if its correct
     * @param UserRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function emailVerificationPost(UserRequest $request)
    {
        $this->setUsersTraitData($request, \Auth::user());
        $user = $this->verifyEmail();

        if (!empty($user) && $user->is_verified) {
            Auth::loginUsingId($user->id, TRUE);
            $user['token'] = JWTAuth::fromUser(auth()->user());
            session()->put('USER_DATA', $user);
            session()->flash('status', 'Login Successful');
            return redirect(route('front.dashboard.index'))->with('status', __('Email Verified'));
        }
        return redirect()->back()->with('err', __('Please Enter The Correct Code'));
    }

    /**
     * Generate a new verification code and email it to the logged in user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function emailVerificationResend(Request $request)
    {
        if ($request->ajax()) {
            try {
                $this->setUsersTraitData([], \Auth::user());
                $this->resendVerificationCode();
                $message = __('Code Resend Your Email Account');
            } catch (\Exception $exception) {
                $message = __('Something Going Wrong!');
            }
            echo json_encode(array(
                'success' => $message
            ));
            die();
        }
        return redirect()->back();
    }

    public function socialRegisterform()
    {
        $this->breadcrumbTitle = __('Complete Social Register');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Complete Social Register')];
        return view('front.auth.social-register');
    }

    public function error404()
    {
        return view('errors.404');
    }

    public function catalogues()
    {
        $this->breadcrumbTitle = __('Catalogues');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Catalogues')];
        $catalogues = Catalog::paginate(10);
        // dd($catalogues);
        return view('front.home.catalogs', ['catalogs' => $catalogues]);
    }

    public function getDownload($path)
    {
        $file = env('BASE_Catalog_PATH') . '/' . $path;
//        $file= public_path('uploads\\').$path;
        $headers = array(
            'Content-Type: application/pdf',
        );


        return \Response::download($file, 'Catalog.pdf', $headers);
    }

    /**
     * Get the list saved branches and send it to the locations page.
     */
    public function branches()
    {

        $this->breadcrumbTitle = __('Locations');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Locations')];

        $branches = $this->branch->all();
        $this->setTranslations($branches);
        return view('front.home.locations', compact('branches'));
    }

    public function appointment(Request $request)
    {

        $this->breadcrumbTitle = __('Book an Appointment');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Book an Appointment')];

        if (empty($request->all())) {
            $details = 0;
            $dateTime = $this->getDateTime();
            $dates = $dateTime['dates'];
            $times = $dateTime['times'];
        } else {
            $details = $request->except('_token');
        }

//        dd($details);
        return view('front.home.book-appointment', compact('details', 'dates', 'times'));
    }

    public function makeAppointment(Request $request)
    {

        $data = $request->except('_token');

        $category = $this->category->findById($data['vehicle']);
        $data['vehicle'] = $category->translation->name;

        $category = $this->category->findById($data['model']);
        $data['model'] = $category->translation->name;

        $branch = $this->branch->findBySlug($data['location']);
        $data['location'] = $branch->translation->title;

        $data['receiver_email'] = config('settings.email');
        $data['receiver_name'] = config('settings.company_name');
        $data['sender_name'] = $data['first_name'] . ' ' . $data['last_name'];
        $subject = __("New Appointment Booking");
        $data['subject'] = $subject;

//        SendEmail::dispatch($data, 'emails.book-appointment', $subject,$data['receiver_email'], $data['email']);
//
        $this->sendMail($data, 'emails.book-appointment', $subject, $data['receiver_email'], $data['email']);

        return redirect(route('front.index'))->with('status', __('Appointment email has been sent'));

    }

    public function makeAppointmentIndexPage(Request $request)
    {
        $data = $request->except('_token');

        $branch = $this->branch->findBySlug($data['location']);
        $data['location'] = $branch->translation->title;

        $data['receiver_email'] = config('settings.email');
        $data['receiver_name'] = config('settings.company_name');
        $data['sender_name'] = $data['name'];
        $subject = __("New Appointment Booking");
        $data['subject'] = $subject;
//        SendEmail::dispatch($data, 'emails.book-appointment', $subject,$data['receiver_email'], $data['email']);
//
        $this->sendMail($data, 'emails.book-appointment-index', $subject, $data['receiver_email'], $data['receiver_email']);

        return redirect(route('front.index'))->with('status', __('Appointment email has been sent'));

    }

    public function servicePackages()
    {
        $this->breadcrumbTitle = __('Service Packages');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Service Packages')];

        $servicePackages = $this->product->getServicePackages();

        return view('front.home.packages', compact('servicePackages'));
    }

    public function brands()
    {
        $this->breadcrumbTitle = __('Our Brands');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Our Brands')];

        $brands = $this->brand->getBrands();

        return view('front.home.brands', compact('brands'));
    }

    public function promotions()
    {
        $this->breadcrumbTitle = __('Promotions');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Promotions')];

        $promotions = $this->promotion->getPromotions();

        return view('front.home.promotions', compact('promotions'));
    }

    public function siteMap()
    {
        $this->breadcrumbTitle = __('Site Map');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Site Map')];

        $services = $this->setTranslations(Service::whereHas('languages')->with('languages')->latest()->get());


        return view('front.home.site-map', compact('services'));
    }

    public function getDateTime()
    {
        $dates = [];
        for ($i = 0; $i < 14; $i++) {
            array_push($dates, Carbon::now()->addDays($i)->toDateString());
        }
        $times = [];
        $carbon = Carbon::create();
        $carbon->hours(8);
        for ($i = 0; $i < 11; $i++) {
            array_push($times, $carbon->addHour()->format('g:i A'));
        }

        return compact('dates', 'times');
    }




//    public function getBrands(){
//        $brands = [];
//        $data = ;
//        foreach ($data as $brand){
//   $temp = new \stdClass();
//   $temp->id = $brand->id;
//   $temp->name = $brand->translation->name;
//   $temp->slug = $brand->slug;
//
//   array_push($brands, $temp);
//        }
//        return $brands;
//    }

}
