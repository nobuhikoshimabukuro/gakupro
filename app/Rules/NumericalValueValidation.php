<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NumericalValueValidation implements Rule
{
     /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private int $MinimumValue,private int $MaximumValue)
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
        
        if(intval($value) >= $this->MinimumValue && intval($value) <= $this->MaximumValue){
            return true;            
        }else{
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ":attributeは{$this->MinimumValue}以上、{$this->MaximumValue}以下で設定してください。";
    }
}
