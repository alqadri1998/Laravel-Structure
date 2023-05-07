<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//        $user = \Auth::user();
        $rules=[
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'user_image' => 'image',
//            'user_phone' =>'required|numeric',
//            'gender'=> 'required',
//            'address'=> 'required',
            'email' => 'required|max:255|email',
            'password' => 'nullable|min:6|confirmed',
        ];
        if ($this->request->get('user_id') == 0){
//            $rules['user_image'] = 'required|image';
            $rules['email']='required|max:255|email|unique:users,email';
        }
        return $rules;

    }
}
