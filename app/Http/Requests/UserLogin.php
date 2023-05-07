<?php

namespace App\Http\Requests;

class UserLogin extends SDTyres {

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
    public function rules() {
        return [
            'device_type' => 'required|in:android,ios',
            'device_id' => 'required|max:512',
            'email' => 'required_without_all:google_id,facebook_id|email',
            'password' => 'required_without_all:google_id,facebook_id',
            'google_id' => 'required_without_all:email,password,facebook_id',
            'facebook_id' => 'required_without_all:email,password,google_id',
        ];
    }

}
