<?php

namespace App\Http\Requests;

class SaveUserProfile extends SDTyres {

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
        $routeAlias = $this->route()->action['as'];
        if (str_contains($routeAlias, 'update-profile')) {
            return [
                'first_name' => 'required|max:45',
                'last_name' => 'required|max:45',
                'mobile' => 'nullable|between:10,15',
                'city' => 'nullable|max:100',
                'gender' => 'required|in:male,female',
                'address' => 'nullable|max:512',
                'profile_pic' => 'image'
            ];
        }
        else {
            return [
                'current_password' => 'required',
                'password' => 'required|min:6|confirmed',
            ];
        }
    }

}
