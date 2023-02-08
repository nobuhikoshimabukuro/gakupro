<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


//カタカナチェック
//※引数について：1 = 半角カナ、2 = カタカナ
use App\Rules\KatakanaValidation;

//数値上限下限チェック
//引数について：第一引数 = 最小値、第二引数 = 最大値。月の場合はnew NumericalValueValidation(1,12)
use App\Rules\NumericalValueValidation;

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

class majorsubject_m_request extends FormRequest
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
            'school_cd' => [ new RequiredComboBoxValidation()],
            'majorsubject_cd' => '',
            'majorsubject_name' => [ 'required',new WordCountValidation(1,100)],
            'studyperiod' => [new NumericalValueValidation(1,120)],                  
            'remarks' => [ 'nullable',new WordCountValidation(0,1000)],
        ];
    }

    public function attributes()
    {
        return [
            
            'school_cd' => '学校',
            'majorsubject_cd' => '',
            'majorsubject_name' => '専攻名',
            'studyperiod' => '学習期間（ヶ月）',            
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
