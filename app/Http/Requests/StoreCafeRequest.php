<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCafeRequest extends FormRequest
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
            'name' => 'required|max:20|min:2',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required|regex:/\b\d{6}\b/'
        ];
    }

    /**
     * 
     * 获取验证提示字符
     * @return array
     */
    public function messages(){
        return [
            'name.required' => '咖啡店的名字不能为空',
            'name.max' => '咖啡店名字长度不能超过20个字符',
            'name.min' => '咖啡店名字长度不能小于2个字符',
            'address.required' => '咖啡店地址不能为空',
            'city.required' => '咖啡店城市不能为空',
            'state.required' => '咖啡店省份不能为空',
            'zip.required' => '咖啡店的邮政编码不能为空',
            'zip.regex' => '邮政编码非法'
        ];
    }
}
