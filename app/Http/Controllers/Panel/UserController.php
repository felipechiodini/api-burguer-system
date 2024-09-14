<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Mail\Panel\ResetPassword;
use App\Models\User;
use App\Rules\CellphoneRule;
use App\Utils\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'min:6'],
            'cellphone' => ['required', new CellphoneRule],
        ]);

        User::query()
            ->create([
                'name' => Helper::capitalizeName($request->name),
                'email' => Str::lower($request->email),
                'password' => Hash::make($request->password),
                'cellphone' => Helper::clearAllIsNotNumber($request->cellphone)
            ]);

        $message = 'Usuario criado com sucesso';

        $token = auth()->attempt(['email' => $request->email, 'password' => $request->password]);

        $user = auth()->user();

        Log::channel('slack')->info('User created', ['user' => $user]);

        return response()
            ->json(compact('message', 'user', 'token'));
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
