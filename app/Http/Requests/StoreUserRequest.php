<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'username' => 'required|unique:users|min:4',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4|max:32',
            'role_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'username.unique' => "Username đã tồn tại",
            'email.unique' => "Email đã tồn tại",
            'password.min' => "Password có độ dài tối thiểu là :min",
            'password.max' => 'Password có độ dài tối đa là :max'
        ];
    }
}
