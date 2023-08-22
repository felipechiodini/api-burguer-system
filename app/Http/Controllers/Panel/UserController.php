<?php

namespace App\Http\Controllers\Panel;

use App\Cart\User;
use App\Http\Controllers\Controller;
use App\MercadoPago\MercadoPago;
use App\Models\Plan;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cellphone' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        ModelsUser::query()
            ->create([
                'name' => $request->name,
                'email' => $request->email,
                'cellphone' => $request->cellphone,
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

    public function deleteAccount()
    {
        ModelsUser::query()
            ->find(auth()->user()->id)
            ->delete();

        return response()
            ->json(['message' => 'Conta excluída com sucesso!']);
    }
}
