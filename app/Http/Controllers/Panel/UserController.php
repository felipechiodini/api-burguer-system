<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\Helper;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'cellphone' => 'required'
        ]);

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

}
