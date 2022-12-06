<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => ['required','exists:user'],
            'password' => ['required','string']
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Vui lòng bạn nhập tài khoản Email',
            'password.required' => 'Vui lòng bạn nhập mật khẩu',
            'email.exists' => 'Email này không tồn tại',
        ];
    }
}
