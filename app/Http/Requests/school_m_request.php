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

class school_m_request extends FormRequest
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
            'school_division' => [ new RequiredComboBoxValidation()],
            'school_name' => [ 'required',new WordCountValidation(1,100)],
            'post_code' => [ 'nullable',new PostalCodeValidation()],
            'address1' => [ 'nullable',new WordCountValidation(0,300)],
            'address2' => [ 'nullable',new WordCountValidation(0,300)],            
            'tel' => ['nullable',new TelephoneNumberValidation() ,new WordCountValidation(0,15)],            
            'fax' => ['nullable',new TelephoneNumberValidation() ,new WordCountValidation(0,15)],            
            'hp_url' => ['nullable','url'],
            'mailaddress' => ['nullable','email',new WordCountValidation(0,200)],            
            'remarks' => [ 'nullable',new WordCountValidation(0,1000)],
        ];
    }

    public function attributes()
    {
        return [
            
            'school_division' => '学校区分',
            'school_name' => '学校名',
            'post_code' => '郵便番号',
            'address1' => '住所1',
            'address2' => '住所2',
            'tel' => '電話番号',
            'fax' => 'FAX',
            'hp_url' => 'HPのURL',
            'mailaddress' => 'メールアドレス',            
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
