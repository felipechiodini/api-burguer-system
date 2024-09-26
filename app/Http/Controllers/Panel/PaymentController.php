<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StorePayment;
use Illuminate\Http\Request;
use App\Enums\Order\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = collect(Payment::asArray())
            ->map(function($payment) {
                $model = StorePayment::query()
                    ->where('type', $payment)
                    ->first();

                return [
                    'active' => (bool) @$model->active,
                    'type' => $payment,
                    'key' => Payment::getKey($payment),
                    'name' => Payment::getDescription($payment)
                ];
            });

        return response()
            ->json(compact('payments'));
    }

    public function toogleStatus(String $tenant, String $key, Request $request)
    {
        $enum = Payment::fromKey($key);

        $payment = StorePayment::query()
            ->where('type', $enum->value)
            ->first();

        if ($payment === null) {
            StorePayment::create([
                'type' => $enum->value,
                'active' => true
            ]);
        } else {
            $payment->update(['active' => !$payment->active]);
        }

        return response()
            ->json(['message' => 'Tipo de pagamento atualizado!']);
    }
}
