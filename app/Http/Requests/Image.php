<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Image extends FormRequest
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
        if (str_contains($routeAlias, 'admin.upload-image')) {
            $rules = [
                'image' => 'mimes:jpeg,jpg,png,gif|max:10000'
            ];
        }
        if (str_contains($routeAlias, 'admin.logo.store')) {
            $rules = [
                'images.*' => 'mimes:jpeg,jpg,png,gif|max:10000'
            ];
        }
        if (str_contains($routeAlias, 'admin.slider.store')) {
            $rules = [
                'images.*' => 'mimes:jpeg,jpg,png,gif|max:10000'
            ];
        }
        if (str_contains($routeAlias, 'admin.products.product-images.store')) {
            $rules = [
                'images.*' => 'mimes:jpeg,jpg,png,gif|max:10000'
            ];
        }
        return $rules;
    }
}
