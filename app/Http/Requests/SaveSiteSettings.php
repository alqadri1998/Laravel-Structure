<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveSiteSettings extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'contact_email' => 'required|email|max:255',
            'telephone_number' => 'required|between:10,20',
            'address' => 'required|max:512',
            'website' => 'nullable|url|max:512',
            'facebook_page_url' => 'nullable|url|max:512',
            'twitter_page_url' => 'nullable|url|max:512',
            'google_page_url' => 'nullable|url|max:512',
            'linkedin_page_url' => 'nullable|url|max:512',
            'youtube_page_url' => 'nullable|url|max:512',
        ];
    }

}
