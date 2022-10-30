<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIncubationRequest extends FormRequest
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
        $validationRules = [

        ];

        return $validationRules;
    }

    public function withValidator($validator) {
        $validator->after(function($validator) {
            $data = $this->post();

            if(isset($data['web'])) {
                if(strlen($data['web']) > 255) {
                    $validator->errors()->add('web', 'Ovo polje ne može imati više od 255 karaktera!');
                }

                if(!str_contains($data['web'], 'http://') && !str_contains($data['web'], 'https://')) {
                    $validator->errors()->add('web', 'Pogrešan format!');
                }
            }
        });
    }
}
