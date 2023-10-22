<?php

namespace App\Http\Controllers\Panel;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\StoreOrder;
use Illuminate\Http\Request;
use DB;

class OrderManagerController extends Controller
{

    public function index(Request $request)
    {
        $orders = StoreOrder::query()
            ->with([
                'customer',
                'delivery.address',
                'payment',
                'items.product',
                'items.additionals.additional',
                'items.replacements.replacement'
            ])
            ->when($request->has('status'), function($query) use(&$request) {
                $query->where('status', $request->query('status'));
            })
            ->when($request->has('id'), function($query) use(&$request) {
                $query->where('id', $request->query('id'));
            })
            ->where('id', 1)
            ->get()
            ->map(function($order) {
                return $order;
            });

        return response()
            ->json(compact('orders'));
    }

    public function preparation(Request $request)
    {
        DB::beginTransaction();

        StoreOrder::query()
            ->find($request->order_id)
            ->update([
                'status' => OrderStatus::PREPARATION
            ]);

        DB::commit();

        return response()
            ->json(['message' => 'Status alterado para em preparação.']);
    }

    public function shipped(Request $request)
    {
        DB::beginTransaction();

        StoreOrder::query()->find($request->order_id)
            ->update([
                'status' => OrderStatus::SHIPPED
            ]);

        DB::commit();

        return response()
            ->json(['message' => 'Status alterado para enviado.']);
    }

    public function canceled(Request $request)
    {
        DB::beginTransaction();

        StoreOrder::query()->find($request->order_id)
            ->update([
                'status' => OrderStatus::CANCELED
            ]);

        DB::commit();

        return response()
            ->json(['message' => 'Status alterado para enviado.']);
    }

}
