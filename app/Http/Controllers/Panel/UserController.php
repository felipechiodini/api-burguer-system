<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'password' => 'cellphone',
        ]);

        User::query()
            ->create($request->only([
                'name',
                'email',
                'password',
                'cellphone',
            ]));

        return response()
            ->json(['message' => 'Usuário criado com sucesso']);
    }

}
