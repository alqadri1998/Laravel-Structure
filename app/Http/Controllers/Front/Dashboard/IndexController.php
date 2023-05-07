<?php

namespace App\Http\Controllers\Front\Dashboard;

use App\Http\Libraries\Uploader;
use App\Http\Requests\User\UserRequest;
use App\Models\Address;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\User;
use App\Traits\Users;
use Auth;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use function Sodium\add;

class IndexController extends Controller
{
    use Users;

    public $address;
    public $subscription;

    public function __construct(Address $address, Subscription $subscription)
    {
        parent::__construct();
        $this->breadcrumbs[route('front.dashboard.index')];
        $this->address = $address;
        $this->subscription = $subscription;

    }

    /**
     * Takes the user to my account page, the first page of dashboard.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $this->breadcrumbTitle = __('My Account');
        $this->breadcrumbs['javascript: {};'] = ['title' => 'My Account'];
        $billingAddress = $this->address->getDefaultBilling();
        $shippingAddress = $this->address->getDefaultShipping();
        $subscriberEmail = $this->subscription->checkEmailExists();
        $subscribed = 0;
/*        $session_id = session()->getId();
        $user = User::find(auth()->user()->id);
        $user->update(['session_id' => $session_id]);*/
        if (!is_null($subscriberEmail)) {
            $subscribed = 1;
        }
        return view('front.dashboard.profile', compact('billingAddress', 'shippingAddress', 'subscribed'));
    }

    public function editProfile()
    {
        $this->breadcrumbTitle = 'Account Information';
        $this->breadcrumbs['javascript: {};'] = ['title' => 'Account Information'];
        $user = Auth::user();
//        dd($user);
        return view('front.dashboard.edit-profile', compact('user'));
    }

    public function subscriptionPage()
    {
        $this->breadcrumbTitle = 'News Letter Subscription';
        $this->breadcrumbs['javascript: {};'] = ['title' => 'News Letter Subscription'];
        $subscriberEmail = $this->subscription->checkEmailExists();
        $subscribed = 0;
        if (!is_null($subscriberEmail)) {
            $subscribed = 1;
        }
        return view('front.dashboard.subscription', compact('subscribed'));
    }

    /**
     * Save email of the user into the subscription table
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subscription(Request $request)
    {
        if ($request->has('checked')) {
            $userEmail['email'] = auth()->user()->email;
            Subscription::create($userEmail);
            return redirect()->back()->with('status', 'Subscribed Successfully');

        } else {
            $subscription = Subscription::where('email', auth()->user()->email)->first();
            if ($subscription->delete()) {
                return redirect()->back()->with('status', 'Subscription removed');
            }
        }
    }

    public function uploadImage(Request $request)
    {
        $imageUploadedPath = '';
        if ($request->hasFile('image')) {
            $uploader = new Uploader('image');
            if ($uploader->isValidFile()) {
                $uploader->upload('user', $uploader->fileName);
                if ($uploader->isUploaded()) {
                    $imageUploadedPath = $uploader->getUploadedPath();
                }
            }
            if (!$uploader->isUploaded()) {
                return 0;
            }
        }
        return response(['status_code' => '200', 'message' => 'Image Has Been Uploaded Successfully.', 'data' => $imageUploadedPath]);
    }

    public function deleteImage(Request $request)
    {

        User::where('id', auth()->user()->id)->update(['user_image' => '']);
        return response(['status_code' => 200, 'message' => 'Image Deleted Successfully']);
    }

    public function updateProfile(Request $request)
    {
        $data = $request->except('_token', 'change_email', 'change_password', 'email', 'new_password', 'current_password');
        if ($request->has('change_email')) {
            if (\Hash::check($request->current_password, auth()->user()->getAuthPassword())) {
                $data['email'] = $request->email;
            } else {
                return back()->with('err', 'Current password incorrect');
            }
        }

        if ($request->has('change_password')) {
            if (\Hash::check($request->current_password, auth()->user()->getAuthPassword())) {
                $data['password'] = Hash::make($request->new_password);
            } else {
                return back()->with('err', 'Current password incorrect');
            }
        }
        $user = User::updateOrCreate(['id' => auth()->user()->id], $data);
        $user['token'] = session('USER_DATA.token');
        $userData = $user;
        session()->forget('USER_DATA');
        session()->put('USER_DATA', $userData);
        return back()->with('status', 'User Profile Has Been Updated Successfully');
    }

    public function addFavorites($id)
    {
        $user = User::find(auth()->user()->id);
        $user->favorites()->syncWithoutDetaching($id);
        return response('success');
    }

    public function deleteFavorites($id)
    {
        $user = User::find(auth()->user()->id);
        $user->favorites()->detach($id);
        return response('success');
    }

    public function favorites()
    {
        $this->breadcrumbTitle = 'Favorites';
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Favorites')];
        $favorites = function ($favorites) {
            $favorites->where('user_id', auth()->user()->id);
        };
        $products = Product::whereHas('favorites', $favorites)->whereHas('languages')->with('languages')->get();
        $this->setTranslations($products);
        return view('front.dashboard.favourite', ['products' => $products]);
    }

    public function changePassword()
    {
        $this->breadcrumbTitle = __('Changed Password');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Change Password')];
        return view('front.dashboard.change-password');
    }

    public function updatePassword(UserRequest $request)
    {
        $this->setUsersTraitData($request, \Auth::user());
        $user = $this->updateUserPassword();
        if ($user) {
//            session()->put('USER_DATA.password', $user->password);
            return redirect(route('front.dashboard.index'))->with('status', __('Password Changed successfully'));
        }
        return redirect()->back()->with('err', __('Invalid Current password.'));
    }

    public function paymentProfile()
    {
        return view('front.checkout.payment-profile');
    }

    public function addressBook()
    {
        $this->breadcrumbTitle = __('Address Book');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Address Book')];

        $addresses = $this->address->getUserAddress();
        $billingAddress = $this->address->getDefaultBilling();
        $shippingAddress = $this->address->getDefaultShipping();

        return view('front.dashboard.address-book', compact('addresses', 'billingAddress', 'shippingAddress'));
    }


//    Address crud functions
    public function editAddress($id)
    {
        if ($id == 0) {
            $this->breadcrumbTitle = __('Add New Address');
            $this->breadcrumbs['javascript: {};'] = ['title' => __('Add New Address')];

            return view('front.dashboard.edit-address');

        }
        $this->breadcrumbTitle = __('Edit Address');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Edit Address')];

        $address = $this->address->findById($id);

        return view('front.dashboard.edit-address', compact('address'));
    }

    public function updateAddress(Request $request, $id)
    {
        $data = $request->except('_token');
        $data['user_id'] = auth()->id();

        if ($request->has('default_billing')) {
            $this->address->removeBillingDefault();
            $data['default_billing'] = 1;
        }

        if ($request->has('default_shipping')) {
            $this->address->removeShippingDefault();
            $data['default_shipping'] = 1;
        }

        if ($id == 0) {
            $address = $this->address->Create($data);
        } else {
            $address = $this->address->updateOrCreate(['id' => $id], $data);
        }

        return redirect(route('front.dashboard.address.index'));
    }

    public function destroyAddress($id)
    {
        $address = $this->address->findById($id);
        if ($address->default_billing == 1) {
            return redirect()->back()->with('err', __('This is a default billing address, please select a new default billing address before deleting'));
        }
        if ($address->default_shipping == 1) {
            return redirect()->back()->with('err', __('This is a default shipping address, please select a new default shipping address before deleting'));
        }
        if ($address->delete()) {
            return redirect()->back()->with('status', __('Address deleted'));
        }
    }

}
