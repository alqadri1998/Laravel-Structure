<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SDTyres extends FormRequest {

    public function response(array $errors) {
        if ($this->expectsJson()) {
            $firstErrorMessage = array_first($errors);
            $response = ['success' => false, 'message' => $firstErrorMessage[0], 'data' => ['collection' => [],
                'pagination' => new \stdClass()], 'errors' => []];
            foreach ($errors as $inputName => $messages) {
                $response['errors'][$inputName] = [
                    'hasError' => true,
                    'message' => array_first($messages)
                ];
            }
            return response($response);
        }
        return $this->redirector->to($this->getRedirectUrl())
                        ->withInput($this->except($this->dontFlash))
                        ->withErrors($errors, $this->errorBag);
    }

}
