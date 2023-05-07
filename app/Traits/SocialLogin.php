<?php
/**
 * Created by PhpStorm.
 * User: Malik
 * Date: 7/12/2017
 * Time: 1:40 PM
 */
namespace App\Traits;


use App\Models\User;
use Auth;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

trait SocialLogin {

    public function redirectToProvider($provider) {
        return Socialite::driver($provider)->redirectUrl(route('social-callback',['provider'=> $provider]))->redirect();
    }

    public function handleProviderCallback($provider) {
        $user = Socialite::driver($provider)->redirectUrl(route('social-callback',['provider'=> $provider]))->user();
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::loginUsingId($authUser->id);
        $userAuth=Auth::user();
        $customClaims = [];
        if ($authUser->account_type==User::$ACCOUNT_TYPE_SHOWROOM) {
            if (count($authUser->store) > 0) {
                $customClaims['showroom_id'] = $authUser->store->id;
            }
        }
        $userAuth['authorization'] = JWTAuth::fromUser($authUser, $customClaims);
        session()->put('USER_DATA',$userAuth->toArray());
        return redirect(route('user.profile'));
    }

    public function findOrCreateUser($user, $provider) {
        $userData = User::where([$provider.'_id' => $user->id])->first();
        if (count($userData) <= 0) {
            $userEmail = User::where('email', $user->email)->first();
            if (count($userEmail) > 0) {
                $userEmail->update([$provider . '_id', $user->id]);
                return $userEmail;
            } else {
                return User::create([
                    'first_name' => $user->name,
                    'email' => $user->email,
                    $provider . '_id' => $user->id,
                    'email_verified' => '1',
                    'verification_code'=>'',
                    'is_active'=> 1,
                    'account_type' => 'buyer'
                ]);
            }
        }
        return $userData;
    }

}