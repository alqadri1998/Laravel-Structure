<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $routeAlias = $this->route()->action['as'];
        $rules = [];
        if (str_contains($routeAlias, 'front.auth.register')) {
            $this->errorBag = 'register';
            $rules = [
                'first_name' => 'required|max:45',
                'last_name' => 'required|max:45',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|alpha_dash|confirmed|max:32',
                'password_confirmation' => 'required|min:6|alpha_dash|max:32',
                'terms&conditions' => 'required',
//                'address' => 'required',
                'phone' => ['regex:/^([+]|[00]{2})([0-9]|[ -])*/','min:12','max:14']
            ];
        }
        if (str_contains($routeAlias, 'password.update')) {
            if (empty(\Auth::user()->password)) {
                $rules = [
                    'password' => 'required|alpha_dash|min:6|confirmed',
                ];

            } else {
                $rules = [
                    'current_password' => 'required',
                    'password' => 'required|min:6|alpha_dash|confirmed',
                ];
            }
        }
        if (str_contains($routeAlias, 'forgotPassword.submit')) {
            $rules = [
                'email' => 'email|required|exists:users,email'
            ];
        }
        if (str_contains($routeAlias, 'resetPassword.submit')) {
            $rules = [
                'email' => 'email|required|exists:users,email',
                'password' => 'required|min:6|alpha_dash|confirmed',
                'verification_code' => 'required|exists:users,verification_code'
            ];
        }
        if (str_contains($routeAlias, 'profile.update')) {
            $user = \Auth::user();
            $rules = [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'user_phone' => ['required','regex:/^([+]|[00]{2})([0-9]|[ -])*/','min:12','max:14'],
                'address' => 'required|max:255',
                'email' => 'required|max:255|email|unique:users,email,' . $user->id .',id',
                'city_id' => 'required|integer|exists:cities,id'
            ];

        }
        if (str_contains($routeAlias, 'front.verification.submit')) {
            $rules = [
                'verification_code' => 'required|integer'
            ];
        }
        if (str_contains($routeAlias, 'front.dashboard.update-profile')) {
            $rules = [
                'first_name' => 'required|max:45',
                'last_name' => 'required|max:45',
                'last_name' => 'required|max:45',
//                'user_phone' => ['required','regex:/^([+]|[00]{2})([0-9]|[ -])*/','min:12','max:14']

            ];
        }
        if (str_contains($routeAlias, 'front.checkout.update.address')) {
        $rules = [
            'first_name' => 'required|max:45',
            'last_name' => 'required|max:45',
            'email' => 'required|email|max:255',
            'address' => 'required|max:255',
            'user_phone' => ['required','regex:/^([+]|[00]{2})([0-9]|[ -])*/'],
            'street_address' => 'required|max:255',
            // 'post_code' => 'required|max:255',
            'shipping_first_name' => 'required_with:shipping_to|max:45',
            'shipping_last_name' => 'required_with:shipping_to|max:45',
            'shipping_email' => 'required_with:shipping_to|email|max:255',
            'shipping_user_phone' => ['required_with:shipping_to','regex:/^([+]|[00]{2})([0-9]|[ -])*/'],
            'shipping_address' => 'required_with:shipping_to|max:45',
            'shipping_street_address' => 'required_with:shipping_to|max:45',
            // 'shipping_post_code' => 'required_with:shipping_to|max:45',


        ];
    }
        if (str_contains($routeAlias, 'front.checkout.pay.pal')) {
            $rules = [
                'paypal' => 'required_without:cash_on_delivery',
                'cash_on_delivery' => 'required_without:paypal',
            ];
        }


        return $rules;
    }

    public function messages()
    {
        return [
            'user_phone.required' => 'Phone number is required',
            'user_phone.regex' => 'please enter the phone number in correct format',
            'first_name.required'  => 'First name  is required',
            'first_name.max'  => 'First name  can be maximum upto 45 characters',
            'last_name.required'  => 'Last name  is required',
            'last_name.max'  => 'Last name  can be maximum upto 45 characters',
            'street_address.required' => 'Street Address is required',
            'street_address.max' => 'Street Address can be maximum upto 255 characters',
            'verification_code.max' => 'Verification code  should not greater than 4 digits',




        ];
    }



}
