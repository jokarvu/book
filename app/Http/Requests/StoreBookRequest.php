<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
            'category_id' => 'bail|required|numeric|exists:categories,id',
            'name' => 'bail|required',
            'author' => 'bail|required',
            'price' => 'bail|required|numeric',
            'quantity' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'category_id' => [
                'required' => 'Bạn phải chọn danh mục',
                'numeric' => 'Danh mục không hợp lệ!',
                'exists' => 'Danh mục không tồn tại'
            ],
            'name.reuqired' => 'Bạn phải nhập tên sách',
            'author.required' => 'Bạn phải nhập tên tác giả',
            'price' => [
                'required' => 'Bạn phải nhập giá tiền của sách',
                'numeric' => 'Giá tiền phải là số'
            ],
            'quantity' => [
                'required' => 'Bạn phải nhập số lượng',
                'numeric' => 'Số lượng phải là số nguyên',
            ]
        ];
    }
}
