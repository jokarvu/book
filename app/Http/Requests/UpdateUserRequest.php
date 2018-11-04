<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => 'bail|required|email',
            'username' => 'bail|required|min:4|max:32',
            'role_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Bạn phải nhập email',
            'email.email' => 'Bạn phải nhập email',
            'username.required' => 'Bạn phải nhập username',
            'username.min' => 'Username tối thiểu dài :min kí tự',
            'username.max' => 'Username dài tối đa :max kí tự'
        ];
    }
}
