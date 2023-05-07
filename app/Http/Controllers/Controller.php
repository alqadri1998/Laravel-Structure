<?php

namespace App\Http\Controllers;

use App\Http\Libraries\DataTable;
use App\Models\Attribute;
use App\Models\Branch;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Repair;
use App\Models\Service;
use App\Models\User;
use App\Traits\Translations;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;

class Controller extends BaseController
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
        Translations;

    public $user, $breadcrumbs, $breadcrumbTitle, $userId;

    public function __construct($userDataKey = 'userData', $guard = null)
    {

        $this->middleware(function ($request, $next) use ($guard) {
            $this->user = ($guard == 'admin') ? session('ADMIN_DATA') : session('USER_DATA');
            return $next($request);
        });
        \View::composer('*', function ($view) use ($userDataKey, $guard) {

            $currencyId = session('CURRENCY_ID', config('app.currencies.AED'));
            $currencies = cache('CURRENCIES');


            $conversionRates = cache('CONVERSION_RATES');
            $currency = $currencies[session('CURRENCY_ID', env('DEFAULT_CURRENCY_ID', 1))];
            if (!$guard) {
                $languages = [];
                $segments = request()->segments(1);
                $queryParams = explode('?', request()->fullUrl());

/*                foreach (cache('LANGUAGES') as $lang) {
                    $segments[0] = $lang['short_code'];
                    $languages[$lang['short_code']] = [
                        'title' => $lang['title'],
                        'url' => url(implode('/', $segments) . ((count($queryParams) > 1) ? '?' . $queryParams[1] : ''))
                    ];
                }*/
//                if (Cache::has('categories')){
//                    $categories = Cache::get('categories');
//                }else{
                $categories = Category::whereHas('languages')->with(['languages', 'subCategories' => function ($subCategories) {
                    $subCategories->whereHas('languages')->with(['languages', 'subCategories' => function ($query) {
                        $query->whereHas('languages')->with('languages');
                    }]);
                }])->where('parent_id', 0)->orderBy('created_at', 'DESC')->get();
                $this->setTranslations($categories, 'languages', ['subCategories' => 'languages']);
                unset($categories->languages);
                foreach ($categories as $key => $value) {
                    foreach ($value->subCategories as $modelKey => $model) {
                        if (count($model->subCategories) > 0) {
                            $this->setTranslations($model->subCategories);
                            unset($model->subCategories->languages);
                        }

                    }
                }

                Cache::add('categories', $categories, 1440);
//                }

                if (auth()->check()) {
                    $cartCount = Cart::where('user_id', auth()->user()->id)->get();
                    session()->put('cart', count($cartCount));
                }

                $branches = $this->setTranslations(Branch::latest()->get());
                $services = $this->setTranslations(Service::whereHas('languages')->with('languages')->where('type', '!=', 'repair')->latest()->limit(5)->get());
                $repairs = $this->setTranslations(Service::whereHas('languages')->with('languages')->where('type','repair')->latest()->limit(5)->get());
//                $repairs = $this->setTranslations(Repair::whereHas('languages')->with('languages')->latest()->get());
                $width = $this->getSpecificAttribute('Width');
                $height = $this->getSpecificAttribute('Height');
                $dateTime = $this->getDateTime();
//                return response($branches)->throwResponse();
                $view->with([
                    $userDataKey => $this->user,
                    'user' => $this->user,
                    'maintenance_mode' => session('maintenanceMode', 1),
                    'breadcrumbs' => $this->breadcrumbs,
                    'breadcrumbTitle' => $this->breadcrumbTitle,
                    'locale' => config('app.locale'),
                    'title' => config('settings.company_name'),
                    'languages' => $languages,
                    'currency' => $currency,
                    'currencies' => $currencies,
                    'currencyId' => $currencyId,
                    'currencySymbol' => config('app.currencySymbols.' . $currency),
                    'currencyTitle' => $currencies[$currencyId],
                    'conversionRates' => $conversionRates,
                    'categories' => $categories,
                    'bodyClass' => config('app.locales.' . config('app.locale')) == 1 ? 'rtl' : '',
                    'max' => Product::max('price'),
                    'userData' => $this->user,
                    'branches' => $branches,
                    'indexServices' => $services,
                    'indexRepairs' => $repairs,
                    'width' => $width,
                    'height' => $height,
                    'dates' => $dateTime['dates'],
                    'times' => $dateTime['times'],
                ]);
            } else {

                // admin data
                $adminData = session('ADMIN_DATA');
//                $notifications = Notification::where(['is_read'=>0, 'user_id'=>$adminData['id']])->get();
                $view->with([
//                    'adminNotifications' => $notifications,
//                    'adminNotificationsCount' => count($notifications),
                    $userDataKey => $this->user,
                    'admin' => $this->user,
                    'maintenance_mode' => session('maintenanceMode', 1),
                    'locales' => config('app.locales'),
                    'userData' => $this->user,
                    'locale' => config('app.locale'),
                    'breadcrumbs' => $this->breadcrumbs,
                    'siteSettings' => config('settings'),
                    'currentRouteName' => \Route::current()->getName(),
                    'breadcrumbTitle' => $this->breadcrumbTitle,
                    'adminData' => $this->user,

                ]);
            }
        });
    }

    public function getSpecificAttribute($name){
        $attributes = Attribute::whereHas('languages')->with(['languages','subAttributes'])->get();
        $this->setTranslations($attributes, 'languages', ['subAttributes'=>'languages']);

        $filtered = $attributes->filter(function ($value, $key) use($name){
            return strtolower($value->translation->name) == strtolower($name);
        });
        $attribute =  $filtered->all();
//       return response($attribute)->throwResponse();
        return reset($attribute);

    }

    public function getDateTime(){
        $dates = [];
        for ($i= 0; $i<14; $i++ ){
            array_push($dates,Carbon::now()->addDays($i)->toDateString());
        }
        $times = [];
        $carbon = Carbon::create();
        $carbon->hours(8);
        for ($i= 0; $i<11; $i++ ){
            array_push($times,$carbon->addHour()->format('g:i A'));
        }

        return compact('dates', 'times');
    }

}
