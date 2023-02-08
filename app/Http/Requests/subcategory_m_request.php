<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

//カタカナチェック
//※引数について：1 = 半角カナ、2 = カタカナ
use App\Rules\KatakanaValidation;

//文字数チェック
//※引数について：第一引数 = 最小文字数、第二引数 = 最大文字数
//※引数を第一引数のみにすると、第一引数の数値と値の桁数の一致確認処理を行います
use App\Rules\WordCountValidation;

//電話番号チェック
use App\Rules\TelephoneNumberValidation;

//郵便番号番号チェック
use App\Rules\PostalCodeValidation;

//必須のコンボボックス値チェック
use App\Rules\RequiredComboBoxValidation;

class subcategory_m_request extends FormRequest
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
            'maincategory_cd' => [new RequiredComboBoxValidation()],
            'subcategory_cd' => '',
            'subcategory_name' => [ 'required',new WordCountValidation(0,100)],
            'display_order' => [ 'numeric'],         
        ];
    }

    public function attributes()
    {
        return [
            
            'maincategory_cd' => '大分類',
            'subcategory_cd' => '',
            'subcategory_name' => '中分類名',
            'display_order' => '表示順',            
        ];
    }
    public function messages()
    {
        return [
            'required' => ':attributeは必ず入力してください。',
        ];
    }
}
