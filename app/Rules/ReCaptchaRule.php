<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class ReCaptchaRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $response = Http::asMultipart()
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => config('recaptcha.v3.private_key'),
                    'response' => $value,
                    'remoteip' => request()->ip(),
                ]);
        } catch (\Throwable $th) {
            $fail('Falha ao validar captcha');
        }

        if ($response->json('success') === false) {
            $fail('Falha ao validar captcha');
        }
    }
}
