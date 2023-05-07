<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Traits\Users;
use Config;
use Laravel\Socialite\Two\InvalidStateException;
use Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class SocialLoginController extends Controller
{
    use Users;
    public function redirect($service)
    {
        session()->put('user_locale',app()->getLocale());

        return Socialite::driver($service)->redirect();
    }
    public function callback($service)
    {

        try {
            $user = Socialite::driver($service)->user();
        } catch (InvalidStateException $e) {
            $user = Socialite::driver($service)->stateless()->user();
        }
        $requestData = array();
        if ($service == "google") {
            $requestData["google_id"] = $user->id;
            $requestData["email"] = $user->email;
            $requestData["first_name"] = $user->user['given_name'];
            $requestData["last_name"] = '';
            $requestData["profile_pic"] = $user->getAvatar();
        } elseif ($service == "facebook") {
            $requestData["facebook_id"] = $user->id;
            $requestData["email"] = $user->email;
            $fullname = explode(' ', $user->name);
            $requestData["first_name"] = $fullname[0];
            $requestData["last_name"] = $fullname[1];
            $requestData["profile_pic"] = $user->getAvatar();
        }
        elseif ($service == 'instagram'){
            $requestData["instagram_id"] = $user->id;
            $requestData["email"] = $user->email;
            $fullname = explode(' ', $user->name);
            $requestData["first_name"] = $fullname[0];
            $requestData["last_name"] = '';
            if (count($fullname) > 1){
                $requestData["last_name"] = $fullname[1];

            }
            $requestData["profile_pic"] = $user->avatar;
        }

        $this->setUsersTraitData($requestData);
        $userdata = $this->userSocialLogin();

        if ($userdata) {
            \Auth::loginUsingId($userdata->id);
            $userdata = auth()->user();
            $userdata['token'] = JWTAuth::fromUser($userdata);
            $cartCount = \App\Models\Cart::where('user_id',$userdata['id'])->count();
            session()->put('USER_DATA', $userdata);
            session()->flash('status',__('Login Successful'));
            return redirect(session('user_locale').'/dashboard');
        }
        else{

//            return redirect(route('front.social.register.form',['platform'=> $service,'id'=> $user->id,'email'=> $requestData['email'],'first_name'=> $requestData['first_name'],'last_name' => $requestData['last_name']]));
            return redirect(session()->get('user_locale').'/social-register?platform='. $service.'&id='.$user->id.'&email='.$requestData['email'].'&first_name='.$requestData['first_name'].'&last_name='.$requestData['last_name']);
        }
        set_alert('warning', __('Credentials Does Not Match Our Records'));
        return redirect()->back();
    }
}
