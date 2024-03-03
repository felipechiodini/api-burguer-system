<?php

namespace App\Http\Controllers\Panel;

use App\Enums\Order\Delivery;
use App\Http\Controllers\Controller;
use App\Models\StoreDelivery;
use Request;

class DeliveryController extends Controller
{

    public function index()
    {
        $deliveries = collect([]);

        foreach (Delivery::getInstances() as $delivery) {
            $model = StoreDelivery::query()
                ->where('type', $delivery->value)
                ->first('minutes');

            $deliveries->push([
                'name' => @$delivery->description,
                'minutes' => @$model->minutes,
                'active' => $model ?? false
            ]);
        }

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
