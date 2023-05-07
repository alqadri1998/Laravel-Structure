<?php

namespace App\Http\Requests;

class SavePage extends SDTyres {

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
        $pageId = $this->route('page');
        $rules = [
            'language_id' => 'required|exists:languages,id',
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'image',

        ];
//        if ($this->request->get('page_id') == 0){
//            $rules['image'] = 'required|image';
//        }
        return $rules;
    }

}
