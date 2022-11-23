<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRaisingStartsRequest extends FormRequest
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
            'rstarts_team_history' => 'max:300',
            'rstarts_app_motive' => 'max:300',
            'rstarts_tagline' => 'max:80',
            'rstarts_solve_problem' => 'max:500',
            'rstarts_targetted_market' => 'max:500',
            'rstarts_problem_solve' => 'max:500',
            'rstarts_which_product' => 'max:800',
            'rstarts_customer_problem_solve' => 'max:500',
            'rstarts_benefits' => 'max:500',
            'rstarts_clarification_innovative' => 'max:500',
            'rstarts_research' => 'max:1000',
            'rstarts_innovative_area' => 'max:1000',
            'rstarts_business_plan' => 'max:800',
            'rstarts_statup_progress' => 'max:500',
            'rstarts_mentor_program_history' => 'max:500',
            'rstarts_logo' => 'mimes:jpg,jpeg,bmp,png,gif',
            'rstarts_founder_links' => 'max:1000',
            'rstarts_links' => 'max:1000',
            'rstarts_financing_proof_links' => 'max:1000',
            'rstarts_linkclip' => 'max: 400',
            'rstarts_other_sources' => 'max:1000',
            'rstarts_expectations' => 'max:500',
            'rstarts_howmuchmoney' => 'max:500',
            'rstarts_financing_sources' => 'max:500',
            'six_months_income' => 'numeric',
            'memberName' => 'max:1000',
            'memberEducation' => 'max:1600',
            'memberRole' => 'max:1000',
            'memberOtherJob' => 'max:400',
            'founderName.*' => 'max: 100',
            'founderPart.*' => 'numeric'
        ];

        return $validationRules;
    }

    public function withValidator($validator) {

        $validator->after(function ($validator) {
            $data = $this->post();

            if(count($data['memberEducation']) > 0) {
                foreach($data['memberEducation'] as $education) {
                    if(strlen($education) > 2500) {
                        $validator->errors()->add('memberEducation', 'Ovaj unos ne sme imati više od 2500 karaktera!');
                        break;
                    }
                }
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

            if(isset($data['rstarts_webpage'])) {
                if(strlen($data['rstarts_webpage']) > 255) {
                    $validator->errors()->add('rstarts_webpage', 'Ovo polje ne može imati više od 255 karaktera!');
                }

                if(!str_contains($data['rstarts_webpage'], 'http://') && !str_contains($data['rstarts_webpage'], 'https://')) {
                    $validator->errors()->add('rstarts_webpage', 'Pogrešan format!');
                }
            }

        });

    }
}
