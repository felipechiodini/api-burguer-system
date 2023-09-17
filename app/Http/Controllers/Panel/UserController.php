<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Mail\Panel\ResetPassword;
use App\Models\Plan;
use App\Models\User;
use App\Utils\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'cellphone' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        User::query()
            ->create([
                'name' => Helper::captalizeName($request->name),
                'email' => Str::lower($request->email),
                'cellphone' => Helper::clearAllIsNotNumber($request->cellphone),
                'password' => Hash::make($request->password)
            ]);

        return response()
            ->json(['message' => 'Registrado com sucesso!']);
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'plan_id' => 'required'
        ]);

        $modelPlan = Plan::query()
            ->find($request->plan_id);

        // MercadoPago::getPlan($modelPlan->foreing_id)
        //     ->subscribe(User::make(auth()->user()->id));

        return response()
            ->json([
                'message' => 'Assinado com sucesso!'
            ]);
    }

    public function sendMailResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Informe um e-mail',
            'email.email' => 'Informe um e-mail válido',
            'email.exists' => 'E-mail não encontrado'
        ]);

        $token = Helper::resetPasswordToken(50);

        $user = User::query()
            ->where('email', $request->email)
            ->first();

        $user->update([
            'token' => $token,
            'token_expires_in' => now()->addMinutes(30)->toDateTimeString()
        ]);

        Mail::to($user->email)
            ->queue(new ResetPassword($user, $token));

        return response()
            ->json(['message' => 'Você receberá um email com as instruções para redefinir sua senha']);
    }

    public function resetPasswordByToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string'
        ]);

        $user = User::query()
            ->where('token', $request->token)
            ->firstOrFail();

        if (now()->isAfter($user->token_expires_in)) {
            throw ValidationException::withMessages(['token' => 'Token expirado']);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'token' => null,
            'token_expires_in' => null
        ]);

        return response()
            ->json(['message' => 'Senha alterada com sucesso']);
    }

}
