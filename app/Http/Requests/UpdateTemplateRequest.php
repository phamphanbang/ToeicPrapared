<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateTemplateRequest extends FormRequest
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
            'name' => ['required','string','unique:test_template,name,'.$this->old_name.',name' ,'max:255'],
            'description' => ['required','string',],
            'num_of_question' => ['required','integer',],
            'num_of_part' => ['required','integer',],
            'duration' => ['required','integer',],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'unique' => 'The :attribute is already existed',
        ];
    }
}
