<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminManagerRequest extends FormRequest
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
        $user_id = request()->id;
        return [
            'fullname' => 'required|max:255|string',
            'username' => 'required|max:255|string|unique:admins,username,' . $user_id,
            'password' => 'required|max:255|string' . $user_id,
            'email' => 'required|max:255|email|unique:admins,email,' . $user_id,
            'phone_number' => 'nullable|max:255',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'fullname' => 'Họ và tên',
            'username' => 'Tên đăng nhập',
            'password' => 'Mật khẩu',
            'phone_number' => 'Số điện thoại',
            'email' => 'Email',
        ];
    }
}