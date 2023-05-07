<?php

namespace App\Http\Controllers\Front\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('guest', ['except' => 'logout']);
        $this->breadcrumbTitle = 'Sitemap';
        parent::__construct();
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
//        dd($request->password);
        if (auth()->attempt($credentials, $request->get('remember'))) {

//            if (!is_null(auth()->user()->session_id)){
//                $user = User::find(auth()->user()->id);
//                $user->update(['is_logged' => 1, 'session_id'=> null]);
//                Session::getHandler()->destroy($user->session_id);
//                auth()->logout();
//                throw ValidationException::withMessages([
//                    $this->username() => __('Your account has been blocked contact admin'),
//                ]);
////                return redirect()->route('front.index');
//            }
//
//            if (auth()->user()->is_logged == 1){
//                auth()->logout();
//                throw ValidationException::withMessages([
//                    $this->username() => __('Your account has been blocked contact admin'),
//                ]);
////                return redirect()->route('front.index');
//            }

            set_alert('success', __('Login Successfully'));
            $user = auth()->user();
            $user['token'] = JWTAuth::fromUser($user);
            $cartCount = \App\Models\Cart::where('user_id', auth()->user()->id)->count();
            session()->put('USER_DATA', $user);
            session()->flash('status', __('Login Successful'));
//            if (session('url.intended')){
                return redirect(session('url.intended'));
//            }else{
//                return redirect('front.dashboard.index');
//            }
        }
        set_alert('danger', __('Please Provide Correct Email Or Password'));
    }

    public function logout(Request $request)
    {
//        $user = User::find(auth()->user()->id);
//        $user->update(['session_id'=> null]);
        auth()->logout();
        set_alert('success', __('Logout Successfully!'));
        session()->forget('USER_DATA');
        session()->forget('CART_PRODUCTS');
        session()->forget('cart');
//        return redirect('/' . config('app.locale'));
        return redirect('/');
    }

    public function showLoginForm()
    {
        $this->breadcrumbTitle = __('Login Account');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Login Account')];

        return view('front.auth.login');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = User::where('email', $request->email)->withTrashed()->first();
        if ($user !== null && $user->deleted_at != null) {
            throw ValidationException::withMessages([
                $this->username() => __('Your Account Has Been Deleted! Contact Admin!'),
            ]);
        }
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    public function redirectTo()
    {
//        return config('app.locale') . '/dashboard';
        return '/dashboard';
    }


}