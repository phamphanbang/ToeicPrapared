<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateTestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'modder') {
            return true;
        }
        else return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required','string'],
            'audio_file' => ['file','required'],
            'part.*.cluster.*.question_content' => ['required','string'],
            'part.*.cluster.*.attachment' => ['required','file'],
            'part.*.cluster.*.question.*.question' => ['required','string'],
            'part.*.cluster.*.question.*.attachment' => ['required','file'],
            'part.*.cluster.*.question.*.option_1' => ['required','string'],
            'part.*.cluster.*.question.*.option_2' => ['required','string'],
            'part.*.cluster.*.question.*.option_3' => ['required','string'],
            'part.*.cluster.*.question.*.option_4' => ['required','string'],

            'part*.question.*.question' => ['required','string'],
            'part*.question.*.attachment' => ['required','file'],
            'part*.question.*.option_1' => ['required','string'],
            'part*.question.*.option_2' => ['required','string'],
            'part*.question.*.option_3' => ['required','string'],
            'part*.question.*.option_4' => ['required','string'],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute is required',
        ];
    }
}
