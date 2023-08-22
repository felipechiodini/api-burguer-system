<?php

namespace App\Http\Controllers\Panel;

use App\Models\Order;
use App\Models\OrderPayment;
use Illuminate\Http\Request;

class OrderPaymentController extends Controller
{

    public function store(Order $order, Request $request)
    {
        $request->validate([
            'payment_type_id' => 'required|exists:order_payments,id',
            'value' => 'required|numeric'
        ]);

        OrderPayment::create([
            'order_id' => $order->id,
            'payment_type_id' => $request->payment_type_id,
            'value' => 'wdads',
        ]);

        return response()->json(['message' => 'Pagamento cadastrado!']);
    }


}
