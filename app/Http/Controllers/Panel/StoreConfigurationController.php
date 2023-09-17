<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreConfigurationController extends Controller
{

    public function get()
    {
        $configuration = app('currentTenant')
            ->configuration()
            ->first();

        return response()
            ->json(compact('configuration'));
    }

    public function updateOrCreate(Request $request)
    {
        $request->validate([
            'warning' => 'string|nullable',
            'minimum_order_value' => 'numeric'
        ]);

        app('currentTenant')
            ->configuration()
            ->updateOrCreate($request->all());

        return response()
            ->json(['message' => 'Configurações salvas com sucesso!']);
    }

}
