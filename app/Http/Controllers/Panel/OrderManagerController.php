<?php

namespace App\Http\Controllers\Panel;

use App\Enums\Order\Delivery;
use App\Enums\Order\Payment;
use App\Enums\Order\Status;
use App\Events\OrderDispatched;
use App\Http\Controllers\Controller;
use App\Models\DeliveryAddress;
use App\Models\OrderAddress;
use App\Models\OrderDelivery;
use App\Models\OrderPayment;
use App\Models\OrderProduct;
use App\Models\StoreAddress;
use App\Models\StoreCustomer;
use App\Models\StoreOrder;
use App\Utils\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderManagerController extends Controller
{

    public function index(Request $request)
    {
        $orders = StoreOrder::query()
            ->select(['id', 'customer_id', 'origin', 'status', 'total', 'created_at'])
            ->when($request->query('status'), function($query) use(&$request) {
                $query->where('status', $request->query('status'));
            })
            ->when($request->query('id'), function($query) use(&$request) {
                $query->where('id', $request->query('id'));
            })
            ->orderBy('id', 'desc')
            ->get()
            ->transform(function(StoreOrder $order) {
                $customer = StoreCustomer::query()
                    ->select('name')
                    ->where('id', $order->customer_id)
                    ->first();

                $address = OrderAddress::query()
                    ->select('cep', 'neighborhood')
                    ->where('order_id', $order->id)
                    ->first();

                $payment = OrderPayment::query()
                    ->select('type')
                    ->where('order_id', $order->id)
                    ->first();

                return [
                    'id' => $order->id,
                    'total' => Helper::formatCurrency($order->total),
                    'status' => $order->status,
                    'status_label' => Status::getDescription($order->status),
                    'ordered_since' => Carbon::parse($order->created_at)->diffForHumans(now()),
                    'neighborhood' => @$address->neighborhood,
                    'payment_type' => Payment::getDescription($payment->type),
                    'customer' => [
                        'name' => explode(' ', $customer->name)[0],
                    ],
                ];
            });

        return response()
            ->json(compact('orders'));
    }

    public function show(string $slug, StoreOrder $order)
    {
        $products = OrderProduct::query()
            ->select([
                'store_products.name',
                'store_products.description',
                'order_products.amount',
                'order_products.value',
                'order_products.observation',
            ])
            ->join('store_products', fn ($join) => $join->on('store_products.id', 'order_products.product_id'))
            ->where('order_id', $order->id)
            ->get()
            ->map(function($order) {
                return [
                    'name' => $order->name,
                    'description' => $order->description,
                    'amount' => $order->amount,
                    'value' => Helper::formatCurrency($order->value),
                    'observation' => $order->observation,
                ];
            });

        $customer = StoreCustomer::query()
            ->select('name', 'cellphone')
            ->where('id', $order->customer_id)
            ->first();

        $payment = OrderPayment::query()
            ->select('type')
            ->where('order_id', $order->id)
            ->first();

        $address = OrderAddress::query()
            ->select('street', 'number', 'neighborhood', 'city')
            ->where('order_id', $order->id)
            ->first();

        $response = [
            'id' => $order->id,
            'status' => $order->status,
            'created_at' => Carbon::parse($order->created_at)->translatedFormat('H:i'),
            'products_total' => Helper::formatCurrency($order->products_total),
            'delivery_fee' => Helper::formatCurrency($order->delivery_fee),
            'total' => Helper::formatCurrency($order->total),
            'customer' => $customer,
            'address' => $address,
            'products' => $products,
            'delivery' => [
                'type' => $order->delivery,
                'type_label' => Delivery::fromValue($order->delivery)->description
            ],
            'payment' => [
                'type' => $payment->type,
                'type_label' => Payment::fromValue($payment->type)->description
            ],
        ];

        if ($order->discount > 0) {
            $response['discount'] = Helper::formatCurrency($order->discount);
        }

        return response()
            ->json(['order' => $response]);
    }

    public function confirm(String $slug, StoreOrder $order)
    {
        if ($order->status !== Status::OPEN) {
            throw new \Exception('Operação inválida para este status');
        }

        $newStatus = Status::PREPARATION;

        $order->update([
            'status' => $newStatus
        ]);

        OrderDispatched::dispatch($order);

        return response()
            ->json([
                'message' => 'Pedido confirmado',
                'status' => $newStatus,
                'label' => Status::getDescription($newStatus)
            ]);
    }

    public function dispatchOrder(String $slug, StoreOrder $order)
    {
        if ($order->status !== Status::PREPARATION) {
            throw new \Exception('Operação inválida para este status');
        }

        $newStatus = Status::DISPATCHED;

        $order->update([
            'status' => $newStatus
        ]);

        return response()
            ->json([
                'message' => 'Pedido despachado',
                'status' => $newStatus,
                'label' => Status::getDescription($newStatus)
            ]);
    }

    public function cancel(String $slug, StoreOrder $order)
    {
        $order->update([
            'status' => Status::CANCELED
        ]);

        return response()
            ->json(['message' => 'Pedido cancelado']);
    }

}
