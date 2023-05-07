<?php

namespace App\Http\Controllers\Admin\Auth;

use Auth;
use \App\Traits\Permissions;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Password Reset Controller
      |--------------------------------------------------------------------------
      |
      | This controller is responsible for handling password reset requests
      | and uses a simple trait to include this behavior. You're free to
      | explore this trait and override any methods you wish to tweak.
      |
     */

use ResetsPasswords, Permissions;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest:admin');
        parent::__construct('adminData', 'admin');
        \Password::setDefaultDriver('admin');
    }
    
    public function redirectTo() {
        return route('admin.home.index');
    }
    
    public function showResetForm(\Illuminate\Http\Request $request, $token = null) {
        return view('admin.auth.passwords.reset', [
            'email' => $request->email,
            'token' => $token,
        ]);
    }
    
    protected function guard() {
        return Auth::guard('admin');
    }
    
    protected function resetPassword($admin, $password) {
        $admin->forceFill([
            'password' => bcrypt($password),
            'remember_token' => str_random(60),
        ])->save();
        $this->guard()->login($admin);
        $adminData = auth('admin')->user();
        session()->put('ADMIN_DATA', $adminData->toArray());
        $this->loadPermissions($adminData->role_id);
        return redirect()->intended(route('admin.home.index'));
    }

}
