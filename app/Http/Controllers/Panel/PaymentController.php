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
        $payments = StorePayment::query()
            ->get()
            ->map(function(StorePayment $storePayment) {
                return [
                    'active' => $storePayment->active,
                    'type' => $storePayment->type,
                    'name' => Payment::getDescription($storePayment->type)
                ];
            });
 
        return response()
            ->json(compact('payments'));
    }

    public function update(String $tenant, String $key, Request $request)
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
