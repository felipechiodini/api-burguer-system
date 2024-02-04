<?php

namespace App\MercadoPago;

use App\Order\User;

class Plan {

    private $plan;

    public function __construct($plan)
    {
        $this->plan = $plan;
    }

    public function subscribe(User $user)
    {
        return Request::base()
            ->withToken(config('mercado-pago.access_token'))
            ->get('preapproval', [
                'preapproval_plan_id' => $this->plan->id,
                'payer_email' => $user->model->email,
                'external_reference' => $user->model->email,
                'auto_recurring' => [
                    'frequency' => 1,
                    'frequency_type' => 'months',
                    'currency_id' => 'BRL'
                ],
                'back_url' => 'https://www.fcbsolucoesweb.com.br',
                'status' => 'pending'
            ]);
    }
}
