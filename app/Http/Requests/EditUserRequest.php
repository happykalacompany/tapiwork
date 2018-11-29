<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
            'profile_visibility' => 'sometimes|boolean'
        ];
    }

    /**
     * 定义字段验证规则的错误返回提示值
     *
     * @return array
     */
    public function messages()
    {
        return [
            'profile_visibility.boolean' => '个人信息是否可见应该是一个bool类型的值'
        ];
    }
}
