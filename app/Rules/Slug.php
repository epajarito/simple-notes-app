<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Slug implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if( preg_match('/_/', $value)){
            $fail("El valor del campo {$attribute} no debe contener guiones bajo.");
        }
        if( preg_match('/^-/', $value) ) {
            $fail("El valor del campo {$attribute} no debe comenzar con guiones.");
        }

        if( preg_match('/-$/', $value) ){
            $fail("El valor del campo data.attributes.slug no debe terminar con guiones.");
        }
    }
}
