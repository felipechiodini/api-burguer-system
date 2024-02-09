<?php

namespace App\Http\Controllers\Panel;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\StoreOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderManagerController extends Controller
{

    public function index(Request $request)
    {
        $orders = StoreOrder::query()
            ->select(['id', 'store_customer_id', 'origin', 'status', 'created_at'])
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
                return [
                    'id' => $order->id,
                    'total' => 'R$ 35,00',
                    'status' => $order->status,
                    'status_label' => OrderStatus::fromValue($order->status)->description,
                    'ordered_since' => 'Pedido realizado ' . Carbon::parse($order->created_at)->diffForHumans(now()),
                    'customer' => [
                        'name' => $order->customer->name,
                        'cellphone' => $order->customer->cellphone
                    ]
                ];
            });

        return response()
            ->json(compact('orders'));
    }

    public function show(String $slug, StoreOrder $order)
    {
        $order->load('customer');
        $order->created_at_label = Carbon::parse($order->created_at)->translatedFormat('H\hm');


        return response()
            ->json(compact('order'));
    }

    public function confirm(String $slug, StoreOrder $order)
    {
        if ($order->status !== OrderStatus::OPEN) {
            throw new \Exception('Operação inválida para este status');
        }

        $newStatus = OrderStatus::PREPARATION;

        $order->update([
            'status' => $newStatus
        ]);

        return response()
            ->json([
                'message' => 'Pedido confirmado',
                'status' => $newStatus,
                'label' => OrderStatus::getDescription($newStatus)
            ]);
    }

    public function dispatchOrder(String $slug, StoreOrder $order)
    {
        if ($order->status !== OrderStatus::PREPARATION) {
            throw new \Exception('Operação inválida para este status');
        }

        $newStatus = OrderStatus::DISPATCHED;

        $order->update([
            'status' => $newStatus
        ]);

        return response()
            ->json([
                'message' => 'Pedido despachado',
                'status' => $newStatus,
                'label' => OrderStatus::getDescription($newStatus)
            ]);
    }

    public function cancel(String $slug, StoreOrder $order)
    {
        $order->update([
            'status' => OrderStatus::CANCELED
        ]);

        return response()
            ->json(['message' => 'Pedido cancelado']);
    }

}
