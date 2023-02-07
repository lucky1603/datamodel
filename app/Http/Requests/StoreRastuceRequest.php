<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRastuceRequest extends FormRequest
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
        return [
            'ntp' => 'in:1,2,3',
            'intention' => 'in:1,2,3',
            'company_type' => 'in:1,2',
            'apply_for_membership_type' => 'in:1,2',
            'company_name' => 'required',
            'id_number' => 'required',
            'founding_date' => 'required',
            'webpage' => 'required',
            'business_branch' => 'in:1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,167',
            'responsible_person' => 'required',
            'responsible_person_email' => 'required|email',
            'responsible_person_phone' => 'required|regex:/0\d{2}\s(\d{3,4})-(\d{3,4})/',
            'innovative_product' => 'required',
            'address' => 'required',
            'gdpr' => 'required',
            'captcha' => 'required|captcha',
        ];
    }
}
