<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AlphaNumericalValidation implements Rule
{
   /**
     * Create a new rule instance.
     *
     * @return void
     */
    //$ProcessingTy 1 = 半角英数字  2 = 英数字  3 = 半角英数字とハイフン（-） 
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
            return preg_match('/^[a-zA-Z0-9]+$/', $value);
        }else if($this->ProcessingType == 2){
            return preg_match('/^[a-zａ-ｚA-ZＡ-Ｚ0-9０-９]+$/', $value);
        }else if($this->ProcessingType == 3){
            return preg_match('/^[a-zA-Z0-9-]+$/', $value);
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
            return ":attributeは半角英数字で入力してください。";
        }else if($this->ProcessingType == 2){
            return ":attributeは英数字で入力してください。";
        }else if($this->ProcessingType == 3){
            return ":attributeは半角英数字とハイフン（-）で入力してください。";
        }
       
    }
}
