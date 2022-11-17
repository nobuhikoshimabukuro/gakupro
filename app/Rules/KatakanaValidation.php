<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class KatakanaValidation implements Rule
{
   /**
     * Create a new rule instance.
     *
     * @return void
     */
    //$ProcessingTy 1 = 半角カタカナ  2 = 全角カタカナ
    public function __construct(private int $ProcessingType)
    {
        //
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
        if($this->ProcessingType == 1){
            return preg_match('/^[ｦ-ﾟ 　]+$/u', $value);                    
        }else if($this->ProcessingType == 2){
            return preg_match('/^[ア-ン゛゜ァ-ォャ-ョーｦ-ﾟ　 ]+$/u', $value);            
        }      
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if($this->ProcessingType == 1){
            return ":attributeは半角カナで入力してください。";
        }else if($this->ProcessingType == 2){
            return ":attributeはカタカナで入力してください。";
        }
       
    }
}
