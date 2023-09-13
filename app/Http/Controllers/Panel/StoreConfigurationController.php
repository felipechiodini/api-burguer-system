<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreConfiguration;
use App\Models\UserStore;
use Illuminate\Http\Request;

class StoreConfigurationController extends Controller
{

    public function get()
    {
        $configuration = StoreConfiguration::first();

        return response()->json($configuration);
    }

    public function updateOrCreate(Request $request)
    {
        $request->validate([
            'warning' => 'string|nullable',
            'minimum_order_value' => 'numeric',
        ]);

        StoreConfiguration::updateOrCreate([
            'user_store_id' => $request->header(UserStore::HEADER_KEY),
        ], $request->all());

        return response()->json(['message' => 'Configurações salvas com sucesso!']);
    }

}
