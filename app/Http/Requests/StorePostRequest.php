<?php

namespace App\Http\Requests;

use App\Attribute;
use App\Business\Program;
use App\Entity;
use App\Http\Controllers\Utils;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'app_type' => 'in: 1,2,3,4',
            'ntp' => 'in: 1,2,3',
            'rstarts_startup_name' => 'required|max:255',
            'rstarts_applicant_name' => 'required|max:255',
            'rstarts_position' => 'required|max:255',
            'rstarts_address' => 'required|max:255',
            'jmbg' => 'required|digits:13',
            'rstarts_email' => 'required|email|max:255',
            'rstarts_telephone' => 'required|max:30',
            'rstarts_webpage' => 'required|url|max:255',
            'rstarts_founding_date' => 'required|date|max:30',
            'rstarts_logo' => 'file|mimes:jpg,jpeg,bmp,png,gif',
            'rstarts_team_history' => 'max:400',
            'rstarts_app_motive' => 'max:1050',
            'rstarts_tagline' => 'max:400',
            'rstarts_solve_problem' => 'max:400',
            'rstarts_targetted_market' => 'max:400',
            'rstarts_problem_solve' => 'max:400',
            'rstarts_which_product' => 'max:400',
            'rstarts_customer_problem_solve' => 'max:400',
            'rstarts_benefits' => 'max:400',
            'rstarts_clarification_innovative' => 'max:400',
            'rstarts_research' => 'max:400',
            'rstarts_innovative_area' => 'max:400',
            'rstarts_business_plan' => 'max:400',
            'rstarts_statup_progress' => 'max:400',
            'rstarts_mentor_program_history' => 'max:1050',
            'rstarts_founder_links' => 'max:200',
            'rstarts_links' => 'max:200',
            'rstarts_financing_proof_links' => 'max:200',
            'rstarts_linkclip' => 'max: 200',
            'rstarts_other_sources' => 'max:200',
            'six_months_income' => 'numeric',
//            'memberName.*' => 'max:200',
//            'memberEducation.*' => 'max:1050',
//            'memberRole.*' => 'max:400',
//            'memberOtherJob.*' => 'max:200',
//            'founderName.*' => 'max: 100',
//            'founderPart.*' => 'numeric',
            'gdpr' => 'required',
            'captcha' => 'required|captcha',
        ];

        // Ako je firma (registrovano društvo) u pitanju.
        if($this['app_type'] != 1) {
            $validationRules['rstarts_id_number'] = 'required|digits:8';
//            $validationRules['rstarts_basic_registered_activity'] = 'required|max:500';
        }

        return $validationRules;
    }

    public function withValidator($validator) {

        $validator->after(function ($validator) {
            $data = $this->post();

            // Check for unique email.
            if(Entity::where('name', 'Profile')->first() != null) {

                if(Attribute::checkValue( Entity::where('name', 'Profile')->first(), 'contact_email', $data['rstarts_email']))
                {
                    $validator->errors()->add('rstarts_email', 'Ova email adresa postoji već u bazi!');
                }

                // Check for unique profile name.
                if(Attribute::checkValue(Entity::where('name', 'Profile')->first(), 'name', $data['rstarts_startup_name']))
                {
                    $validator->errors()->add('rstarts_startup_name', 'Startap sa ovim imenom već postoji u bazi!');
                }

                // Check for unique id number.
                if(Attribute::checkValue(Entity::where('name', 'Profile')->first(), 'id_number', $data['rstarts_id_number']))
                {
                    if($data['app_type'] != 1) {
                        $validator->errors()->add('rstarts_id_number', 'Startap sa maticnim brojem već postoji u bazi!');
                    }
                }

            }

            // Check for the foounding date.
            $dateFounded = date('Y-m-d', strtotime($data['rstarts_founding_date']));
            $time = strtotime('-2 year', time());
            $boundingDate = date('Y-m-d', $time);
            if($boundingDate > $dateFounded) {
                $validator->errors()->add('rstarts_founding_date', 'Datum osnivanja startapa ne može biti stariji od dve godine unazad!');
            }

            if($data['rstarts_innovative_area'] == 16) {
                if($data['rstarts_innovative_area_other'] == '') {
                    $validator->errors()->add('rstarts_innovative_area_other', 'Ako je gornja opcija "Ostalo" ovo polje mora imati vrednost');
                }
            }

            if($data['rstarts_howdiduhear'] == 8) {
                if($data['rstarts_other_sources'] == '') {
                    $validator->errors()->add('rstarts_other_sources', 'Ako je gornja opcija "Ostalo" ovo polje mora imati vrednost');
                }
            }



//            if(count($data['memberName']) < 2 || $data['memberName'][1] == null)
//            {
//                $validator->errors()->add('memberName', 'Tim se mora sastojati od najmanje 2 člana!');
//            }
//
//            if($data['founderName'][0] == null)
//            {
//                $validator->errors()->add('founderName', 'Mora postojati bar jedan osnivač!');
//            }

//
//            if(count($data['memberEducation']) > 0) {
//                foreach($data['memberEducation'] as $education) {
//                    if(strlen($education) > 1050) {
//                        $validator->errors()->add('memberEducation', 'Ovaj unos ne sme imati više od 1050 karaktera!');
//                        break;
//                    }
//                }
//            }
//
//            // Files check.
//            // Obligatory files.
//            $fileAttributes = ['rstarts_files' , 'rstarts_founder_cvs'];
//            foreach ($fileAttributes as $fileAttribute) {
//                if(!$this->hasFile($fileAttribute)) {
//                    $validator->errors()->add($fileAttribute, 'Morate priložiti datoteke!');
//                } else {
//                    $fileEntries = $this->file($fileAttribute);
//                    if($fileAttribute == 'rstarts_founder_cvs' && count($fileEntries) < 2) {
//                        $validator->errors()->add($fileAttribute, 'Morate priložiti bar 2 datoteke!');
//                    }
//
//                    foreach ($fileEntries as $file) {
//                        if ($file->getSize() > 1024 * 1024) {
//                            $validator->errors()->add($fileAttribute, 'Svi fajlovi moraju da budu manji od 1MB');
//                            break;
//                        }
//                    }
//                }
//            }
//
//            // Facultative files.
//            $otherFileAttributes = ['rstarts_financing_proof_files', 'rstarts_dodatni_dokumenti'];
//            foreach($otherFileAttributes as $otherFileAttribute) {
//                if($this->hasFile($otherFileAttribute)) {
//                    $fileEntries = $this->file($otherFileAttribute);
//
//                    foreach ($fileEntries as $file) {
//                        if ($file->getSize() > 1000000) {
//                            $validator->errors()->add($otherFileAttribute, 'Svi fajlovi moraju da budu manji od 1MB');
//                            break;
//                        }
//                    }
//                }
//            }
        });

    }
}
