<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            'user_id' => 'bail|integer',
            'carts' => 'array'
        ];
    }

    public function messages()
    {
        return [
            'user_id.integer' => 'Bạn phải chọn người dùng',
            'carts.array' => 'Bạn phải chọn sách'  
        ];
    }
}
