<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $rules = [
            'titleEn' => 'required|max:255',
//            'titleAr' => 'required|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => "required|regex:/^\d+(\.\d{1,2})?$/|numeric|gt:0",
            // 'discount' => 'numeric|min:0|required_with:offer,1|lt:price',
            'category' => 'required',
//            'subCategory' =>'required'
        ];

        if ($this->request->get('offer') == 1) {
            $rules['discount_percent'] = 'required|numeric|min:0|max:99';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'discount.lt' => 'discount price should be smaller than  product price',
        ];
    }
}
