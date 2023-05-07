<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        $route = $this->route();
        if ($route->action['as']=='api.stores.list')
        {
            return [
                'latitude' => 'required',
                'longitude' => 'required'
            ];
        }

        if ($route->action['as']=='user.store.review')
        {
            return [
                'review' => 'required',
                'rating' => 'required'
            ];
        }

        if ($route->action['as']=='api.store.review.save')
        {
            return [
                'review' => 'required',
                'rating' => 'required',
                'store_id' => 'required|exists:users,id|numeric'
            ];
        }

        /*For Store*/
        $rules = [
            'store_location' => 'required',
            'store_latitude' => 'required|numeric',
            'store_longitude' => 'required|numeric',
            'store_phone' => 'required|max:15',
            'title' => 'required',
            'description' => 'required',
            'language_id' => 'required',
            'store_image'=>'image'
        ];
        if ($route->action['as']=='admin.store.update')
        {
            $rules = [
                'user_id' => 'required|numeric',
            ];
        }
        return $rules;
    }

}
