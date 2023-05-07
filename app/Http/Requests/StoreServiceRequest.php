<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
            'title' => 'required|max:75',
            'description' => 'required',
            'type' => 'required',
            'image' => 'required_if:service_id,0',
            'icon' => 'required_if:service_id,0',
        ];
    }

    public function messages()
    {
        return [
            'image.required_if' => 'Image is required',
            'icon.required_if' => 'Icon is required',
        ];
    }
}
