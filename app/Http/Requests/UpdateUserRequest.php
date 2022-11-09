<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::check()) {
            return true;
        }
        else return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required','string', 'max:255'],
            'email' => ['required','string', 'email', 'max:255', 'unique:user,email,'.$this->old_email.',email'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['mimes:png,jpg,jpeg'],
        ];
    }

    public function messages()
    {
        return [
            'unique' => 'The :attribute is already existed',
            'min' => [
            'string' => 'The :attribute cannot below 8 character'
            ],
            'mimes' => 'Only png,jpg,jpeg are allowed'
        ];
    }
}
