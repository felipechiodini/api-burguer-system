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
        $deliveries = collect(Delivery::asArray())
            ->map(function($type) {
                $model = StoreDelivery::query()
                    ->where('type', $type)
                    ->first();

                return [
                    'active' => @$model->active,
                    'type' => $type,
                    'minutes' => @$model->minutes,
                    'name' => Delivery::getDescription($type)
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
