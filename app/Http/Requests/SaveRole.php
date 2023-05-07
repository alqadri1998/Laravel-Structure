<?php

namespace App\Http\Requests;

class SaveRole extends SDTyres {

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
        $roleId = $this->route('role');
        $rules = [
            'title' => 'required|max:100|unique:roles,title', 
            'description' => 'nullable', 
            'is_active' => 'required|in:0,1', 
            'role_sub_modules' => 'required|json', 
        ];
        if ($roleId > 0) {
            $rules['title'] .= ','.$roleId.',id';
        }
        return $rules;
    }

}
