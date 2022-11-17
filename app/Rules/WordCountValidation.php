<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class WordCountValidation implements Rule
{
   /**
     * Create a new rule instance.
     *
     * @return void
     */

    //第一引数 = 最小文字数、第ニ引数 = 最大文字数
    //※第一引数のみ場合は文字数の一致処理を行う
    public function __construct(private $MinWordCount,private $MaxWordCount = null)
    {
        
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        //値の桁数を取得
        $Length = mb_strlen($value);

        $MinCount =  intval($this->MinWordCount);
        $MaxCount = null;        
   
        //第ニ引数（MaxWordCount）がnull時は第一引数（MinWordCount）で指定された文字数と一致確認
        if(is_null($this->MaxWordCount)){

            if($Length == $MinCount){
                return true;            
            }else{
                return false;
            }

           
        }else{

            $MaxCount = intval($this->MaxWordCount);
            
            if($Length >= $MinCount && $Length <= $MaxCount){
                return true;            
            }else{
                return false;
            }

        }
        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {       
        
        //第ニ引数（MaxWordCount）がnull時は第一引数（MinWordCount）で指定された文字数と一致確認しているいる。不一致時のエラーメッセージ
        if(is_null($this->MaxWordCount)){

            return ":attributeは{$this->MinWordCount}文字で設定してください。";
     
        }else if($this->MinWordCount == 0){

            //第一引数（MinWordCount）で0が指定された場合のエラーメッセージ
            return ":attributeは{$this->MaxWordCount}文字以下で設定してください。";

        }else{

            return ":attributeは{$this->MinWordCount}文字以上、{$this->MaxWordCount}文字以下で設定してください。";

        }
    }
}
