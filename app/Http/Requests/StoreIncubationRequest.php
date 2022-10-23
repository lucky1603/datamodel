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
            'ntp' => 'in:1,2,3',
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
        ];

        if($this['legal_status'] == 2) {
            $rules['id_number'] = 'required';
        }

        return $rules;
    }
}
