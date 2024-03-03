<?php

namespace App\Http\Controllers\Panel;

use App\Enums\Order\Payment;
use App\Http\Controllers\Controller;
use App\Models\StorePayment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function index()
    {
        $payments = collect([]);

        foreach (Payment::getInstances() as $payment) {
            $exists = StorePayment::query()
                ->where('type', $payment->value)
                ->exists();

            $payments->push([
                'key' => $payment->key,
                'name' => $payment->description,
                'active' => $exists
            ]);
        }

        return response()
            ->json(compact('payments'));
    }

    public function status(String $tenant, String $key, Request $request)
    {
        $request->validate([
            'active' => 'required|boolean'
        ]);

        $enum = Payment::fromKey($key);

        StorePayment::query()
            ->updateOrCreate([
                'type' => $enum->value,
            ], [
                'active' => $request->boolean('active')
            ]);

        return response()
            ->json(['message' => 'Tipo de pagamento atualizado!']);
    }

}
