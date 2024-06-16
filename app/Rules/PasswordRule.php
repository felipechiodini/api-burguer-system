<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strlen($value) < 8) {
            $fail('O campo senha deve ter pelo menos 8 caracteres.');
        }
    
        if (!preg_match('/[A-Z]/', $value)) {
            $fail('O campo senha deve conter pelo menos uma letra maiúscula.');
        }
    
        if (!preg_match('/[a-z]/', $value)) {
            $fail('O campo senha deve conter pelo menos uma letra minúscula.');
        }
    
        if (!preg_match('/[0-9]/', $value)) {
            $fail('O campo senha deve conter pelo menos um número.');
        }
    
        if (!preg_match('/[\W_]/', $value)) {
            $fail('O campo senha deve conter pelo menos um caractere especial.');
        }
    }
}
