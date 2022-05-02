<?php

namespace App\Http\Requests;

use App\Attribute;
use App\Entity;
use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
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
    public function rules(): array
    {
        $validationRules = [
            'name' => 'required|max:255',
            'contact_person' => 'required|max:255',
            'contact_email' => 'email|required|max:255',
            'contact_phone' => 'required|regex:/0\d{2}\s(\d{3,4})-(\d{3,4})/',
            'address' => 'required|max:255',
            'profile_webpage' => 'max:255|regex:/https*:\/\/[a-zA-Z0-9]+/',
//            'university' => 'in:1,2,3,4,5,6,7,8',
            'business_branch' => 'in:1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16',
            'short_ino_desc' => 'required',
            'ntp' => 'in:1,2,3'
//            'short_ino_desc' => 'required|max:400'
        ];

        if($this['is_company'] == 'on') {
            $validationRules['id_number'] = 'required|digits:8';
        }

        return $validationRules;
    }

    public function withValidator($validator) {
        $validator->after(function($validator) {
            $data = $this->post();

            if(Entity::where('name', 'Profile')->first() != null) {
                // In the case that the change of id_number is being requested
                // check if the id_number is unique in the database.
                if($data['is_company'] == 'on' && isset($data['id_number'])) {
                    if(Attribute::checkValue(Entity::where('name', 'Profile')->first(), 'id_number', $data['id_number']))
                    {
                        $validator->errors()->add('id_number', 'Startap sa ovim maticnim brojem već postoji u bazi!');
                    }
                }
            }

        });
    }
}
