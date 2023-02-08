<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

//文字数チェック
//※引数について：第一引数 = 最小文字数、第二引数 = 最大文字数
//※引数を第一引数のみにすると、第一引数の数値と値の桁数の一致確認処理を行います
use App\Rules\WordCountValidation;

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
            'maincategory_name' => [ 'required',new WordCountValidation(1,30)],
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
