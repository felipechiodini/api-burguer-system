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
            'minimum_order_value' => 'nullable|numeric',
            'warning' => 'nullable|string',
        ]);

        StoreConfiguration::query()
            ->updateOrCreate([
                'store_id' => app('currentTenant')->id
            ], [
                'minimum_order_value' => $request->minimum_order_value,
                'warning' => $request->warning
            ]);

        return response()
            ->json(['message' => 'Configurações salvas com sucesso!']);
    }
}
