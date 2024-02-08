<?php

namespace App\Rules;

use App\Types\Cellphone as TypesCellphone;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Cellphone implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ((new TypesCellphone($value))->isValid() === false) {
            $fail('O :attribute deve ser um celular válido');
        }
    }
}
