<?php

namespace App\Rules;

use App\Types\Document as TypesDocument;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Document implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ((new TypesDocument($value))->isValid() === false) {
            $fail('O :attribute deve ser um documento válido');
        }
    }
}
