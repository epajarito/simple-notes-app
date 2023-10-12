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
        if($this->hasUnderscores($value)){
            $fail("El valor del campo {$attribute} no debe contener guiones bajo.");
        }
        if($this->startWihDashes($value)) {
            $fail("El valor del campo {$attribute} no debe comenzar con guiones.");
        }

        if($this->endsWithDashes($value)){
            $fail("El valor del campo data.attributes.slug no debe terminar con guiones.");
        }
    }

    /**
     * @param mixed $value
     * @return false|int
     */
    public function hasUnderscores(mixed $value): int|false
    {
        return preg_match('/_/', $value);
    }

    /**
     * @param mixed $value
     * @return false|int
     */
    public function startWihDashes(mixed $value): int|false
    {
        return preg_match('/^-/', $value);
    }

    /**
     * @param mixed $value
     * @return false|int
     */
    public function endsWithDashes(mixed $value): int|false
    {
        return preg_match('/-$/', $value);
    }
}
