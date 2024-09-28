<?php

namespace App\Http\Controllers\Panel;

use App\Enums\Order\Delivery;
use App\Http\Controllers\Controller;
use App\Models\StoreDelivery;

class DeliveryController extends Controller
{
    public function index()
    {
        $deliveries = collect(Delivery::getInstances())
            ->map(function($delivery) {
                $model = StoreDelivery::query()
                    ->where('type', $delivery->value)
                    ->first();

                return [
                    'active' => @$model->active,
                    'key' => $delivery->key,
                    'minutes' => @$model->minutes,
                    'name' => $delivery->description
                ];
            });

        return response()
            ->json(compact('deliveries'));
    }

    public function toogleStatus(string $tenant, string $key)
    {
        $enum = Delivery::fromKey($key);

        $delivery = StoreDelivery::query()
            ->where('type', $enum->value)
            ->first();

        if ($delivery === null) {
            StoreDelivery::create([
                'type' => $enum->value,
                'active' => true
            ]);
        } else {
            $delivery->update(['active' => !$delivery->active]);
        }

        return response()
            ->json(['message' => 'Tipo de entrega atualizado!']);
    }
}
