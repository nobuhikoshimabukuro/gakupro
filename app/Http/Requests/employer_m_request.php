<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


//カタカナチェック
//※引数について：1 = 半角カナ、2 = カタカナ
use App\Rules\KatakanaValidation;

//英数字チェック
//※引数について：1 = 半角英数字、2 = 英数字、3 = 半角英数字とハイフン（-）
use App\Rules\AlphaNumericalValidation;

//数値上限下限チェック
//引数について：第一引数 = 最小値、第二引数 = 最大値。月の場合はnew NumericalValueValidation(1,12)
use App\Rules\NumericalValueValidation;

//数字＆カンマcheck（数字とカンマのみであればOK）
use App\Rules\NumbersWithCommasValidation;

//文字数チェック
//※引数について：第一引数 = 最小文字数、第二引数 = 最大文字数
//※引数を第一引数のみにすると、第一引数の数値と値の桁数の一致確認処理を行います
use App\Rules\WordCountValidation;

use App\Rules\PostalCodeValidation;

use App\Models\employer_m_model;



class employer_m_request extends FormRequest
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

            'employer_name' => [ 'required',new WordCountValidation(1,150)],            
            'employer_name_kana' => ['required',new KatakanaValidation(2) ,new WordCountValidation(1,150)],                 
            'post_code' =>  [ 'nullable',new PostalCodeValidation()],   
            'address1' => ['nullable',new WordCountValidation(0,150)],
            'address2' => ['nullable',new WordCountValidation(0,150)],
            'tel' => ['required',new WordCountValidation(0,20)],
            'fax' => ['nullable',new WordCountValidation(0,20)],
            'hp_url' => ['nullable',new WordCountValidation(0,200)],
            'mailaddress' => ['nullable',new WordCountValidation(0,200)],
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

            'employer_name' => '雇用者名',
            'employer_name_kana' => '雇用者名カナ',
            'post_code' => '郵便番号',
            'address1' => '住所',
            'address2' => '住所',
            'tel' => '電話番号',
            'fax' => 'FAX番号',
            'hp_url' => 'HPのURL',
            'mailaddress' => 'メールアドレス',
        ];
    }

    public function messages()
    {
        return [];
    }
}
