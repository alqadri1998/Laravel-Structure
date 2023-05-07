<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteSetting extends FormRequest
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
        if($this->request->get('key')=='logo' || $this->request->get('key')=='login_page_image'||'email_logo')
        {

            return [
                'key'=> 'required',

            ];
        }
        else
        {
            return [
                'key'=> 'required',
                'value' => 'required'
            ];
        }

    }
}
