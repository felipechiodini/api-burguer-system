<?php

namespace App\Http\Controllers\Panel;

use App\Enums\Order\Delivery;
use App\Http\Controllers\Controller;
use App\Models\StoreDelivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{

    public function index()
    {
        $deliveries = StoreDelivery::query()
            ->get()
            ->map(function(StoreDelivery $storeDelivery) {
                return [
                    'active' => $storeDelivery->active,
                    'type' => $storeDelivery->type,
                    'minutes' => $storeDelivery->minutes,
                    'name' => Delivery::getDescription($storeDelivery->type)
                ];
            });
 
        return response()
            ->json(compact('deliveries'));
    }

    public function active(Int $id, Request $request)
    {
        $request->validate([
            'active' => 'required|boolean',
            'minutes' => 'required'
        ]);

        StoreDelivery::query()
            ->updateOrCreate([
                'type' => $id,
            ], [
                'active' => $request->boolean('active'),
                'minutes' => $request->input('minutes'),
            ]);

        return response()
            ->json(['message' => 'Tipo de entrega atualizado!']);
    }

}
