<?php

namespace App\MercadoPago;

class Subscriptions {

    public function getPlan($planId)
    {
        $response = Request::base()
            ->withToken(config('mercado-pago.access_token'))
            ->get('preapproval_plan', [

            ]);

        return new Plan($response);
    }

    public function createPlan()
    {
        return Request::base()
            ->withToken(config('mercado-pago.access_token'))
            ->get('preapproval_plan', [

            ]);
    }

}
