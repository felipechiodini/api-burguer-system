<?php

namespace App\Rules;

use App\Types\Name as TypesName;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Name implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ((new TypesName($value))->isValid() === false) {
            $fail('O :attribute deve conter nome e sobrenome.');
        }
    }
}
