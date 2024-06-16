<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Mail\Panel\ResetPassword;
use App\Models\User;
use App\Rules\CellphoneRule;
use App\Rules\PasswordRule;
use App\Rules\ReCaptchaRule;
use App\Utils\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|min:3',
            'email' => 'required|email',
            'password' => ['required', new PasswordRule],
            'cellphone' => ['required', new CellphoneRule],
            'recaptcha_token' => [new ReCaptchaRule]
        ]);

        $user = User::query()
            ->where('email', $request->email)
            ->first();

        if ($user) {
            return response()
                ->json(['message' => 'Email já registrado, tentou outro.'], 422);
        }

        User::query()
            ->create([
                'name' => Helper::capitalizeName($request->name),
                'email' => Str::lower($request->email),
                'password' => Hash::make($request->password),
                'cellphone' => Helper::clearAllIsNotNumber($request->cellphone)
            ]);

        return response()
            ->json(['message' => 'Usuário criado com sucesso']);
    }

    public function sendMailForgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::query()
            ->where('email', $request->email)
            ->first();

        if ($user) {
            Mail::to($user->email)
                ->queue(new ResetPassword($user));
        }

        return response()
            ->json(['message' => 'Você recebera um link para redefinir sua senha']);
    }

}
