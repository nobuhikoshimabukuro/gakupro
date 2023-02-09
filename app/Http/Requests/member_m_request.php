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

class member_m_request extends FormRequest
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
            'member_name' => [ 'required',new WordCountValidation(1,100)],            
            'member_name_yomi' => [ 'required',new KatakanaValidation(2),new WordCountValidation(1,100)],            
            'gender' => [ new RequiredComboBoxValidation()],
            'birthday' => [""],
            'tel' => ['nullable',new TelephoneNumberValidation() ,new WordCountValidation(0,15)],            
            'mailaddress' => ['nullable','email',new WordCountValidation(0,100)],
            'school_cd' => [ new RequiredComboBoxValidation()],      
            'majorsubject_cd' => [ new RequiredComboBoxValidation()],
            'admission_yearmonth' => ['required'],
            'graduation_yearmonth' => ['required'],
            'emergencycontact_relations' => ['nullable',new WordCountValidation(0,100)],
            'emergencycontact_tel' => ['nullable',new TelephoneNumberValidation() ,new WordCountValidation(0,15)],                    
            'remarks' => [ 'nullable',new WordCountValidation(0,1000)],
            'registration_status' => [""],
        ];
    }

    public function attributes()
    {
        return [
            
            'member_name' => '氏名',
            'member_name_yomi' => '氏名カナ',
            'gender' => '性別',
            'birthday' => '生年月日',
            'tel' => '電話番号',
            'mailaddress' => 'メールアドレス',
            'school_cd' => '学校',
            'majorsubject_cd' => '専攻',
            'admission_yearmonth' => '入学年月',
            'graduation_yearmonth' => '予定卒業年月',
            'emergencycontact_relations' => '緊急時連絡先の続柄',            
            'emergencycontact_tel' => '緊急時連絡先電話番号',              
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


