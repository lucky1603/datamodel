<?php

namespace App\Http\Requests;

use App\Business\Mentor;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

class MentorRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required',
            'specialities' => 'required',
            'mentor-type' => 'in:1,2'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function($validator) {
            $data = $this->post();
            if(Mentor::find(['email' => $data['email']])->count() > 0) {
                $validator->errors()->add('email', 'Mentor sa ovim email-om već postoji u bazi!');
            }

            if(User::where('email', $data['email'])->count() > 0) {
                $validator->errors()->add('email', 'Korisnik sa ovim email-om već postoji u bazi!');
            }
        });
    }
}
