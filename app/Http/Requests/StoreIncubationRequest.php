<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncubationRequest extends FormRequest
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
        $rules = [
            'program_name_or_company' => 'required|min:1',
            'legal_status' => 'in: 1,2',
            'business_branch' => 'in: 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16',
            'address' => 'required',
            'responsible_lastname' => 'required',
            'responsible_firstname' => 'required',
            'responsible_cellular' => 'required|regex:/0\d{2}\s(\d{3,4})-(\d{3,4})/',
            'responsible_email' => 'required|email',
            'gdpr' => 'required',
            'captcha' => 'required|captcha',
            'id_number' => 'required',
            'date_of_establishment' => 'required|date',
            'pib' => 'required'
        ];

        if($this['legal_status'] == 2) {
            $rules['id_number'] = 'required';
        }

        return $rules;
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
