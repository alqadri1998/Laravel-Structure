<?php

namespace App\Http\Controllers\Front\Auth;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

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

use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct() {
        $this->middleware('guest');
        parent::__construct();
    }



    protected function resetPassword($user, $password) {
        $user->forceFill([
            'password' => bcrypt($password),
            'remember_token' => str_random(60),
        ])->save();

    }
    public function showResetForm(Request $request, $token = null)
    {
        $this->breadcrumbTitle = __('Set New Password');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Set New Password')];
        return view('front.auth.password-reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __('Incorrect Email')]);
    }
}
