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

//必須のコンボボックス値チェック
use App\Rules\RequiredComboBoxValidation;

class staff_m_request extends FormRequest
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
            'staff_name' => [ 'required',new WordCountValidation(1,100)],
            'staff_name_yomi' => [ 'required',new KatakanaValidation(2)],
            'nick_name' => [ 'nullable',new WordCountValidation(0,100)],
            'gender' => [ new RequiredComboBoxValidation()],
            'tel' => ['nullable',new TelephoneNumberValidation() ,new WordCountValidation(0,15)],            
            'mailaddress' => ['nullable','email',new WordCountValidation(0,100)],
            'authority' => [ new RequiredComboBoxValidation()],            
            'remarks' => [ 'nullable',new WordCountValidation(0,1000)],
        ];
    }

    public function attributes()
    {
        return [
            
            'staff_name' => '氏名',
            'staff_name_yomi' => '氏名カナ',
            'nick_name' => 'ニックネーム',
            'gender' => '性別',
            'tel' => '電話番号',
            'mailaddress' => 'メールアドレス',
            'authority' => '権限',
            'remarks' => '備考',
        ];
    }
    public function messages()
    {
        return [
            'required' => ':attributeは必ず入力してください。',
        ];
    }
}
