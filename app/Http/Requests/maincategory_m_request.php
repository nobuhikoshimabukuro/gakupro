<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class maincategory_m_request extends FormRequest
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
            'maincategory_name' => 'required'
        ];
    }

    /**
     * バリデーションエラーのカスタム属性の取得
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'maincategory_name' => '大分類名',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attributeは必ず入力してください。',
        ];
    }
}
