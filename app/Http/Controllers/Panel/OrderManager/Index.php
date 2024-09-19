<?php

namespace App\Http\Controllers\Panel\OrderManager;

use App\Enums\Order\Payment;
use App\Enums\Order\Status;
use App\Http\Controllers\Controller;
use App\Models\DeliveryAddress;
use App\Models\OrderDelivery;
use App\Models\OrderPayment;
use App\Models\StoreAddress;
use App\Models\StoreOrder;
use App\Utils\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Index extends Controller
{
    public function __invoke(Request $request)
    {
        $orders = StoreOrder::query()
            ->select(['id', 'store_customer_id', 'origin', 'status', 'total', 'created_at'])
            ->with('customer:id,name,cellphone')
            ->when($request->query('status'), function($query) use(&$request) {
                $query->where('status', $request->query('status'));
            })
            ->when($request->query('id'), function($query) use(&$request) {
                $query->where('id', $request->query('id'));
            })
            ->orderBy('id', 'desc')
            ->get()
            ->transform(function(StoreOrder $order) {
                $delivery = OrderDelivery::query()
                    ->select('id', 'type')
                    ->Where('store_order_id', $order->id)
                    ->first();

                $address = DeliveryAddress::query()
                    ->select('cep', 'neighborhood')
                    ->where('order_delivery_id', $delivery->id)
                    ->first();

                $payment = OrderPayment::query()
                    ->select('type')
                    ->where('store_order_id', $order->id)
                    ->first();

                $storeAddress = StoreAddress::query()
                    ->select('cep')
                    ->first();

                return [
                    'id' => $order->id,
                    'total' => Helper::formatCurrency($order->total),
                    'status' => $order->status,
                    'status_label' => Status::fromValue($order->status)->description,
                    'ordered_since' => Carbon::parse($order->created_at)->diffInSeconds(now()),
                    'neighborhood' => $address->neighborhood,
                    'distance' => 10,
                    'payment_type' => Payment::getDescription($payment->type),
                    'customer' => [
                        'name' => $order->customer->name,
                        'cellphone' => $order->customer->cellphone
                    ]
                ];
            });

        return response()
            ->json(compact('orders'));
    }
}
