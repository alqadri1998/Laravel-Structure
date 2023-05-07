<?php

namespace App\Http\Requests;

class SaveAdministrator extends SDTyres {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        $adminId = $this->route('administrator');
        $rules = [
            'full_name' => 'required|max:60|regex:/^[a-z0-9\-\s]+$/i',
            'user_name' => 'required',
            'email' => 'required|email|max:100|unique:admins,email',
            'password' => 'required|between:6,32|alpha_num|confirmed',
            'role_id' => 'required|exists:roles,id',
            'profile_pic' => 'image',
            'is_active' => 'required|in:0,1',
            'credit_limit'=>'numeric|min:0',
            'address'=>'required'

        ];
        if ($adminId > 0) {
//            $rules['user_name'] = ['required', 'between:5,30', 'regex:/^[0-9a-zA-Z_]+$/', 'unique:admins,user_name,'.$adminId.',id'];
            $rules['email'] .= ','.$adminId.',id';
            if (empty($this->request->get('password'))) {
                unset($rules['password']);
            }
        }
        return $rules;
    }

}
