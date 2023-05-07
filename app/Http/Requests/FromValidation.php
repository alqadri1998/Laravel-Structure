<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\Console\Input\Input;

class FromValidation extends FormRequest
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
        if (str_contains($routeAlias, 'admin.category.save')) {
            $rules = [
                'name' => 'required|max:255'
            ];
        }
        if (str_contains($routeAlias, 'admin.event.store')) {
           Carbon::parse($this->start_date);
           Carbon::parse($this->end_date);
            $rules = [
                'title' => 'required|max:75',
                'description' => 'required',
                'start_date' => 'required|date|max:255',
                'end_date' => 'required|max:255|after_or_equal:start_date',
                'event_location' => 'required|max:255',
            ];
        }
        if (str_contains($routeAlias, 'admin.slider.store')) {
            $rules = [
                'images' => 'mimes:jpeg,jpg,png,gif|max:10000'
            ];
        }
        if (str_contains($routeAlias, 'admin.products.product-images.store')) {
            $rules = [
                'images' => 'mimes:jpeg,jpg,png,gif|max:10000'
            ];
        }if (str_contains($routeAlias, 'admin.attributes.update')) {
            $rules = [
                'name' => 'required|max:255',
                'is_featured' => 'sometimes|boolean'
            ];
        }
        if (str_contains($routeAlias, 'admin.sub-attributes.update')) {
            $rules = [
                'name' => 'required|max:255'
            ];
        }
        if (str_contains($routeAlias, 'admin.sub-categories.update')) {
            $rules = [
                'name' => 'required|max:255'
            ];
        }

        return $rules;
    }
}
