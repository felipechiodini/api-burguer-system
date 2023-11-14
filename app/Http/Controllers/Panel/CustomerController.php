<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreCustomer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $page = StoreCustomer::query()
            ->paginate(10);

        return response()
            ->json(compact('page'));
    }

    public function store(String $tenant, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'document' => 'string',
            'cellphone' => 'required',
        ]);

        StoreCustomer::query()
            ->create([
                'name' => $request->name,
                'document' => $request->document,
                'cellphone' => $request->cellphone
            ]);

        return response()
            ->json(['message' => 'Cliente cadastrado com sucesso']);
    }

    public function destroy()
    {
        //
    }
}
