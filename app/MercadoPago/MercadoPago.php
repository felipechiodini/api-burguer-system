<?php

namespace App\MercadoPago;

use App\MercadoPago\Plan;
use App\MercadoPago\Subscriptions;

class MercadoPago {

    public static function subscriptions()
    {
        return new Subscriptions();
    }

    public static function getPlan($id)
    {
        $response = Request::base()
            ->withToken(config('mercado-pago.access_token'))
            ->get("plan/{$id}");

        return new Plan($response);
    }
}
