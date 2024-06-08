<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
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
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'repeatPassword' => 'required',
            'role' => 'required|gt:0',
        ];
    }

    public function withValidator($validator) {
        $validator->after(function($validator) {
            $data = $this->post();

            if($data['password'] != $data['repeatPassword']) {
                $validator->errors()->add('repeatPassword', 'Unesene lozinke se razlikuju!');
            }
        });
    }
}
