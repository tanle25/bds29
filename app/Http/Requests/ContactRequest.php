<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'fullname' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'required|max:25',
            'address' => 'required|max:256',
            'messages' => 'required|max:500',
        ];
    }

    public function attributes()
    {
        return [
            'fullname' => 'Họ tên',
            'email' => 'Email',
            'phone_number' => 'Số điện thoại',
            'address' => 'Địa chỉ',
            'messages' => 'Lời nhắn',
        ];
    }
}