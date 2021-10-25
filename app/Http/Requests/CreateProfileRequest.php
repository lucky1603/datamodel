<?php

namespace App\Http\Requests;

use App\Attribute;
use App\Entity;
use Illuminate\Foundation\Http\FormRequest;

class CreateProfileRequest extends FormRequest
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
            'name' => 'required',
            'id_number' => 'required_with:is_company',
            'contact_person' => 'required',
            'contact_email' => 'required|email',
            'contact_phone' => 'required',
            'address' => 'required',
            'short_ino_desc' => 'required',
            'gdpr' => 'required',
            'captcha' => 'required|captcha'
        ];
    }

    public function withValidator($validator) {
        $validator->after(function($validator) {
            $data = $this->post();

            // Profile name
            if(Attribute::checkValue(Entity::where('name', 'Profile')->first(), 'name', $data['name'])) {
                $validator->errors()->add('name', 'Profil sa ovim imenom već postoji u bazi!');
            }

            // id_number
            if(isset($data['id_number']) && Attribute::checkValue(Entity::where('name', 'Profile')->first(), 'id_number', $data['id_number'])) {
                $validator->errors()->add('id_number', 'Matični broj već postoji u bazi!');
            }

            // email
            if(Attribute::checkValue(Entity::where('name', 'Profile')->first(), 'contact_email', $data['contact_email'])) {
                $validator->errors()->add('contact_email', 'Email adresa već postoji u bazi!');
            }

            // profile_logo
            if(!$this->hasFile('profile_logo')) {
                $validator->errors()->add('profile_logo', 'Morate odabrati sliku profila');
            } else {
                $photo = $this->file('profile_logo');
                if($photo->getSize() > 200000) {
                    $validator->errors()->add('profile_logo', 'Slika ne moža biti veća od 200K');
                }
            }

            // university
            // business_branch
            // reason_contact
            $dropDowns = ['university', 'business_branch', 'reason_contact'];
            foreach ($dropDowns as $dropDown) {
                if($data[$dropDown] == 0) {
                    $validator->errors()->add($dropDown, 'Morate izabrati neku vrednost iz liste!');
                }
            }

        });
    }
}
