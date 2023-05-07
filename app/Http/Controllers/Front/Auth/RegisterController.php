<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Requests\User\UserRequest;
use \App\Traits\Users;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

    use Users;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/verification';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        parent::__construct();
    }

    public function showRegistrationForm()
    {
        $this->breadcrumbTitle = __('Create Account');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Create Account')];

        return view('front.auth.register');
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [

        ]);
    }
    public function register(UserRequest $request)
    {
//        dd($request->all());
        $this->setUsersTraitData($request);
        $user = $this->registerUser();
        event(new Registered($user));
        $this->guard()->login($user);
        if ($user->is_verified){
            $user['token'] = JWTAuth::fromUser(auth()->user());
            session()->put('USER_DATA', $user);
            session()->flash('status',__('Login Successful'));
            return redirect(route('front.dashboard.index'));
        }
        session()->put('USER_DATA', $user);
        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }
}
