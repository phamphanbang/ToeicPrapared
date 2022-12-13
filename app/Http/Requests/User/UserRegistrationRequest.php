<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRegistrationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string','unique:user', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Vui lòng bạn điền thông tin vào vùng trên',
            'email.unique' => 'Email này đã có người dùng',
            'name.unique' => 'Tên này đã có người dùng',
            'confirmed' => 'Mật khẩu không trùng khớp',
            'password.min' => 'Mật khẩu không được dưới 8 ký tự'
        ];
    }
}
