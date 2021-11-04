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
        return [
            'app_type' => 'in: 1,2,3,4',
            'ntp' => 'in: 1,2,3',
            'rstarts_startup_name' => 'required',
            'rstarts_applicant_name' => 'required',
            'rstarts_position' => 'required',
            'rstarts_address' => 'required',
            'rstarts_email' => 'required|email',
            'rstarts_telephone' => 'required',
            'rstarts_webpage' => 'url',
//            'rstarts_logo' => 'required|file',
            'rstarts_founding_date' => 'required|date',
            'rstarts_id_number' => 'required|digits:8',
            'rstarts_basic_registered_activity' => 'required|max:500',
            'rstarts_short_ino_desc' => 'required|max:500',
            'rstarts_product_type' => 'in: 1,2,3',
//            'rstarts_founder_links' => 'required_without:rstarts_founder_cvs',
            'rstarts_team_history' => 'required|max:400',
            'rstarts_app_motive' => 'required|max:400',
            'rstarts_tagline' => 'required|max:400',
            'rstarts_solve_problem' => 'required|max:400',
            'rstarts_targetted_market' => 'required|max:400',
            'rstarts_problem_solve' => 'required|max:400',
            'rstarts_which_product' => 'required|max:400',
            'rstarts_customer_problem_solve' => 'required|max:400',
            'rstarts_benefits' => 'required|max:400',
            'rstarts_how_innovative' => 'in:1,2,3,4,5',
            'rstarts_clarification_innovative' => 'required|max:400',
            'rstarts_dev_phase_tech' => 'in:1,2,3,4,5,6',
            'rstarts_dev_phase_bussines' => 'in:1,2,3,4,5,6,7,8,9',
            'rstarts_intellectual_property' => 'in:1,2,3,4,5,6',
            'rstarts_research' => 'required|max:400',
            'rstarts_innovative_area' => 'required|max:400',
            'rstarts_business_plan' => 'required|max:400',
            'rstarts_statup_progress' => 'required|max:400',
//            'rstarts_links' => 'required_without:rstarts_files',
            'rstarts_mentor_program_history' => 'required',
            'rstarts_financing_sources' => 'required',
//            'rstarts_financing_proof_links' => 'required_without: rstarts_financing_proof_files',
            'rstarts_expectations' => 'required',
            'rstarts_howmuchmoney' => 'required',
            'rstarts_linkclip' => 'required',
            'rstarts_howdiduhear' => 'in: 1,2,3,4,5',
            'gdpr' => 'required',
            'captcha' => 'required|captcha'
        ];
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
                    $validator->errors()->add('rstarts_id_number', 'Startap sa maticnim brojem već postoji u bazi!');
                }

            }

            // Check for the foounding date.
            $dateFounded = date('Y-m-d', strtotime($data['rstarts_founding_date']));
            $time = strtotime('-2 year', time());
            $boundingDate = date('Y-m-d', $time);
            if($boundingDate > $dateFounded) {
                $validator->errors()->add('rstarts_founding_date', 'Datum osnivanja startapa ne može biti stariji od dve godine unazad!');
            }

            if(count($data['memberName']) < 2 || $data['memberName'][1] == null)
            {
                $validator->errors()->add('memberName', 'Tim se mora sastojati od najmanje 2 člana!');
            }

            if($data['founderName'][0] == null)
            {
                $validator->errors()->add('founderName', 'Mora postojati bar jedan osnivač!');
            }

            // Logo file check.
            if(!$this->hasFile('rstarts_financing_proof_files')) {
                $validator->errors()->add('rstarts_financing_proof_files', 'Morate priloziti datoteke!');
            }

            // Files check.
            $fileAttributes = ['rstarts_files', 'rstarts_founder_cvs', 'rstarts_financing_proof_files'];
            foreach ($fileAttributes as $fileAttribute) {
                if(!$this->hasFile($fileAttribute)) {
                    $validator->errors()->add($fileAttribute, 'Morate priloziti datoteke!');
                } else {
                    $fileEntries = $this->file($fileAttribute);
                    if($fileAttribute == 'rstarts_founder_cvs' && count($fileEntries) < 2) {
                        $validator->errors()->add($fileAttribute, 'Morate priložiti bar 2 datoteke!');
                    }

                    foreach ($fileEntries as $file) {
                        if ($file->getSize() > 200000) {
                            $validator->errors()->add($fileAttribute, 'Svi fajlovi moraju da budu manji od 200KB');
                            break;
                        }
                    }
                }
            }

        });

    }
}
