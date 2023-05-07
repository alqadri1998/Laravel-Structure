<?php

namespace App\Http\Requests;

use Tymon\JWTAuth\JWTAuth;

class SaveUser extends SDTyres {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $route = $this->route();
        $rules = [];
        if ($route->action['as']=='api.users.register') {
            $rules = [
                'first_name' => 'required|max:45',
                'last_name' => 'required|max:45',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed|max:32',
                'city_id' => 'required|integer|exists:cities,id'
            ];
        }
        if ($route->action['as']=='api.users.profile') {
            $rules = [
                'first_name' => 'required|max:45',
                'last_name' => 'required|max:45',
                'email' => 'required|email',
                'profile_pic' => 'image',
                'city_id' => 'required|integer|exists:cities,id'
            ];
        }

        if ($route->action['as']=='api.users.login') {
            $rules = [
                'fcm_token' => 'required|max:512',
                'email' => 'required_without_all:google_id,facebook_id|email',
                'password' => 'required_without_all:google_id,facebook_id',
                'google_id' => 'required_without_all:email,password,facebook_id',
                'facebook_id' => 'required_without_all:email,password,google_id',
            ];
        }

        if ($route->action['as']=='api.users.change-password') {
            $rules = [
                'current_password' => 'required',
                'password' => 'required|min:6|confirmed',
            ];
        }

        if ($route->action['as']=='api.users.verify-email') {
            $rules = [
                'verification_code' => 'required'
            ];
        }
        if ($route->action['as']=='api.users.forgot-password') {
            $rules = [
                'email' => 'required'
            ];
        }

        if ($route->action['as']=='api.users.reset-password') {
            $rules = [
                'email' => 'required',
                'verification_code' => 'required|integer',
                'password' => 'required|min:6|confirmed',
            ];
        }
        if ($route->action['as']=='store.products') {
            $rules = [
                'store_id' => 'required',
                'verification_code' => 'required|integer',
                'password' => 'required|min:6|confirmed',
            ];
        }
        if ($route->action['as']=='store.products') {
            $rules = [
                'store_id' => 'required',
                'verification_code' => 'required|integer',
                'password' => 'required|min:6|confirmed',
            ];
        }

        return $rules;
    }
    
}
