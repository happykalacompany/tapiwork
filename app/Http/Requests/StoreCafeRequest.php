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
            'locations.*.address' => 'required',
            'locations.*.city' => 'required',
            'locations.*.state' => 'required',
            'locations.*.zip' => 'required',
            'locations.*.brew_method' => 'sometimes|array',
            'website' => 'sometimes|url'
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
            'locations.*.address.required' => '咖啡店地址不能为空',
            'locations.*.city.required' => '咖啡店城市不能为空',
            'locations.*.state.required' => '咖啡店省份不能为空',
            'locations.*.zip.required' => '咖啡店的邮政编码不能为空',
            'locations.*.brew_method.array' => '无效的冲泡方法',
            'website.url' => '无效的网页地址'
        ];
    }
}


