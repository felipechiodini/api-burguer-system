<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreConfiguration;
use Illuminate\Http\Request;

class StoreConfigurationController extends Controller
{

    public function get()
    {
        $configuration = StoreConfiguration::query()
            ->select('warning', 'minimum_order_value')
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

        StoreConfiguration::query()
            ->updateOrCreate([
                'user_store_id' => app('currentTenant')->id
            ], [
                'warning' => $request->warning,
                'minimum_order_value' => $request->minimum_order_value
            ]);

        return response()
            ->json(['message' => 'Configurações salvas com sucesso!']);
    }

}
