<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Utils\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cpf' => 'required',
            'cellphone' => 'required',
            'password' => 'required'
        ]);

        Customer::query()
            ->create([
                'name' => Helper::captalizeName($request->name),
                'cpf' => Helper::clearAllIsNotNumber($request->cpf),
                'cellphone' => Helper::clearAllIsNotNumber($request->cellphone),
                'password' => Hash::make($request->password)
            ]);

        return response()
            ->json(['message' => 'Cadastrado com sucesso!']);
    }

}
