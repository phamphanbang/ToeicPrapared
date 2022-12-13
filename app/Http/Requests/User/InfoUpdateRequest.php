<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class InfoUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required','string','unique:user,name,'.$this->old_name.',name', 'max:30'],
            'email' => ['required','string', 'email', 'unique:user,email,'.$this->old_email.',email'],
            'avatar' => ['mimes:png,jpg,jpeg'],
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'Tài khoản email này đã có người sử dụng',
            'name.unique' => 'Tên người dùng này đã có người sử dụng',
            'mimes' => 'Ảnh đại diện chỉ nhận định dạng png,jpg,jpeg '
        ];
    }
}
