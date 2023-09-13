<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cellphone' => 'required',
            'email' => 'required',
            'message' => 'required'
        ], [
            'name.required' => 'informe seu nome',
            'cellphone.required' => 'informe seu nome',
            'email.required' => 'informe seu e-mail',
            'message.required' => 'informe a mensagem',
        ]);

        Contact::query()
            ->create([
                'name' => $request->name,
                'cellphone' => $request->cellphone,
                'email' => $request->email,
                'message' => $request->message,
            ]);

        return view('index');
    }

    public function createAccount()
    {
        return view('create-account');
    }

    public function fawhfwioa(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ], [
            'name.required' => 'Informe o nome do seu negócio',
            'email.required' => 'Informe seu e-mail',
            'password.required' => 'Informa a senha',
        ]);

        User::query()
            ->create($request->all());

        return view('create-account');
    }

}
