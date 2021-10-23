<?php

namespace App\Http\Requests;

use App\Attribute;
use App\Business\Program;
use App\Entity;
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
            'rstarts_startup_name' => 'required',
            'rstarts_applicant_name' => 'required',
            'rstarts_position' => 'required',
            'rstarts_address' => 'required',
            'rstarts_email' => 'required|email',
            'rstarts_telephone' => 'required',
            'rstarts_webpage' => 'url',
            'rstarts_founding_date' => 'required|date',
            'rstarts_id_number' => 'required',
            'rstarts_basic_registered_activity' => 'required|max:500',
            'rstarts_short_ino_desc' => 'required|max:500',
            'rstarts_product_type' => 'in: 1,2,3',
//            'memberName' => 'min:1',
//            'memberEducation' => 'min:1',
//            'memberRole' => 'min:1',
//            'memberOtherJob' => 'min:1',
//            'founderName.*' => 'required',
//            'founderPart.*' => 'required',
            'rstarts_founder_links' => 'required_without_all:rstarts_founder_cvs.*',
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
            'rstarts_intellectual_property' => 'in:1,2,3,4,5',
            'rstarts_research' => 'required|max:400',
            'rstarts_innovative_area' => 'in:1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16',
            'rstarts_business_plan' => 'required|max:400',
            'rstarts_statup_progress' => 'required|max:400',
            'rstarts_links' => 'required_without_all:rstarts_files.*',
            'rstarts_mentor_program_history' => 'required',
            'rstarts_financing_sources' => 'required',
            'rstarts_financing_proof_links' => 'required_without_all: rstarts_financing_proof_files.*',
            'rstarts_expectations' => 'required',
            'rstarts_howmuchmoney' => 'required',
            'rstarts_linkclip' => 'required',
            'rstarts_howdiduhear' => 'in: 1,2,3,4,5',
        ];
    }

    public function withValidator($validator) {
        $validator->after(function ($validator) {
            $data = $this->post();

            // Check for unique email.
            if(Attribute::checkValue( Entity::where('name', 'Program')->first(), 'rstarts_email', $data['rstarts_email']))
            {
                $validator->errors()->add('rstarts_email', 'Ova email adresa postoji već u bazi!');
            }

            // Check for unique profile name.
            if(Attribute::checkValue(Entity::where('name', 'Profile')->first(), 'name', $data['rstarts_startup_name']))
            {
                $validator->errors()->add('rstarts_startup_name', 'Startap sa ovim imenom već postoji u bazi!');
            }

            if(count($data['memberName']) < 2 || $data['memberName'][1] == null)
            {
                $validator->errors()->add('memberName', 'Tim se mora sastojati od najmanje 2 člana!');
            }

            if($data['founderName'][0] == null)
            {
                $validator->errors()->add('founderName', 'Mora postojati bar jedan osnivač!');
            }
        });
    }

}
