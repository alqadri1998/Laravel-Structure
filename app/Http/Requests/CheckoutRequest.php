<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
        return [
            'payment_method' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'user_phone' => 'required',
//            'address' => 'required',
            'find_us' => 'required',
//            'city' => 'required',
//            'country' => 'required',
//            'post_code' => 'required',
//            'order_notes' => 'required',
//            'vin_number' => 'required',
//            'number_plate' => 'required',
//            'vehicle' => 'required',
//            'model' => 'required',
//            'year' => 'required',
        ];
    }
}
