<?php

namespace App\MercadoPago;

use Illuminate\Support\Facades\Http;

class Request {

    public static function base()
    {
        return Http::asJson()
            ->baseUrl(config('mercado-pago.host'));
    }
}
