<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateTemplateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::user()->role == 'admin') {
            return true;
        }
        else return false;
    }

    public function rules()
    {
        return [
            'name' => ['required','string','unique:test_template' ,'max:255'],
            'description' => ['required','string',],
            'num_of_question' => ['required','integer','min:1'],
            'num_of_part' => ['required','integer','min:1'],
            'duration' => ['required','integer','min:1'],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'unique' => 'The :attribute is already existed',
            'min.num_of_part' => 'Test must have at least :min part',
            'min.num_of_part' => 'Test must have at least :min question',
            'min.duration' => "Test's duration must last at least :min minute",
        ];
    }
}
