<?php

namespace App\Http\Requests;

use App\Attribute;
use App\Entity;
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
            'rstarts_mentor_program_history' => 'max:1050'
        ];

        return $validationRules;
    }

    public function withValidator($validator) {

        $validator->after(function ($validator) {
            $data = $this->post();

            if(count($data['memberEducation']) > 0) {
                foreach($data['memberEducation'] as $education) {
                    if(strlen($education) > 1050) {
                        $validator->errors()->add('memberEducation', 'Ovaj unos ne sme imati više od 1050 karaktera!');
                        break;
                    }
                }
            }

        });

    }
}
