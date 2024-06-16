<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CellphoneRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (preg_match("/^\(\d{2}\) \d{4,5}-\d{4}$/", $value) === false) {
            $fail('Número de telefone inválido');
        }
    }
}
