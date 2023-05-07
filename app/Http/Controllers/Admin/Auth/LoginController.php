<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use Illuminate\Http\Request;
use \App\Traits\Permissions;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Config;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller {
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

use AuthenticatesUsers, Permissions;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $modules;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest:admin', ['except' => 'logout']);
        parent::__construct('adminData', 'admin');
        $this->modules = [];
        $this->driver = new Admin;
    }
    
    public function redirectTo() {
        return route('admin.home.index');
    }
    
    protected function attemptLogin(Request $request) {
        $credentials = $request->only(['email', 'password']);
        $credentials['is_active'] = 1;
        if (auth('admin')->attempt($credentials, $request->get('remember'))) {
            // Authentication passed...
            $admin = auth('admin')->user();
            $admin['token'] = JWTAuth::fromUser($admin);
            session()->put('ADMIN_DATA', $admin->toArray());
//            dd($admin);
            $this->loadPermissions($admin->role_id);
            return redirect()->intended(route('admin.home.index'));
        }
    }
    
    public function showLoginForm() {

        return view('admin.auth.login');
    }
    
    protected function guard() {
        return \Auth::guard('admin');
    }
    
    public function logout(Request $request) {
        auth('admin')->logout();
        session()->forget('SIDEBAR');
        session()->forget('ADMIN_DATA');
        session()->forget('PERMISSIONS');
        session()->forget('LANGUAGES');
        session()->forget('LANG');
        session()->forget('CART_PRODUCTS');
        session()->forget('cart');
        return redirect(route('admin.auth.login.show-login-form'));
    }
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string|min:6',
        ]);
    }

}
