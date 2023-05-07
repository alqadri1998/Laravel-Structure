<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LabelRequest extends FormRequest
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
        $data=$this->request->all();
        $rules= [
           'title'=>'required|max:255',
        ];
        if ($data['label_id']==0){
            $rules['image'] = 'required|image';
            $rules['icon'] = 'required|image';
        }
        return $rules;
    }
}
