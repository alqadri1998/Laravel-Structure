<?php

namespace App\Http\Requests;

class ContactUs extends SDTyres {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'full_name' => 'required',
            'email' => 'required|email',
            'subject' => 'required|in:1,2,3,4,5',
            'message_text' => 'required',
        ];
    }

}
