<?php

namespace App\Http\Controllers\Delivery;

use App\Enums\Order\Delivery as OrderDelivery;
use App\Enums\Order\Origin;
use App\Enums\Order\Payment as OrderPayment;
use App\Enums\Order\Status;
use App\Events\OrderCreated;
use App\Models\OrderAddress;
use App\Models\OrderPayment as ModelsOrderPayment;
use App\Models\OrderProduct as ModelsOrderProduct;
use App\Order\CreateCustomer;
use App\Order\CreateOrder;
use App\Models\StoreProduct;
use App\Models\ProductAdditional;
use App\Models\ProductReplacement;
use App\Models\StoreCustomer;
use App\Models\StoreNeighborhood;
use App\Models\StoreOrder;
use App\Order\Additional;
use App\Order\OrderProduct;
use App\Order\Replacement;
use App\Types\Cellphone;
use App\Types\Document;
use App\Types\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlaceOrder
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'customer.name' => 'required',
            'customer.document' => '',
            'customer.cellphone' => 'required',
            'address.street' => 'required',
            'address.number' => 'required',
            'address.neighborhood_id' => 'required',
            'payment.type' => 'required',
            'delivery.type' => 'required',
            'delivery.observation' => 'string',
            'products' => 'required',
        ]);

        DB::beginTransaction();

        $customer = StoreCustomer::query()
            ->updateOrCreate([
                'cellphone' => $request->json('customer.cellphone')
            ], [
                'name' => $request->json('customer.name'),
                'document' => $request->json('customer.document'),
            ]);

        if ($request->json('delivery.type') === OrderDelivery::DELIVERY) {
            $neighborhood = StoreNeighborhood::query()
                ->where('id', request('address.neighborhood_id'))
                ->first();
        }

        $order = StoreOrder::query()
            ->create([
                'customer_id' => $customer->id,
                'products_total' => 0,
                'delivery_fee' => $neighborhood->price,
                'discount' => 0,
                'total' => 0,
                'delivery' => $request->json('delivery.type'),
                'origin' => Origin::APP,
                'status' => Status::OPEN,
            ]);

        if ($request->json('delivery.type') === OrderDelivery::DELIVERY) {
            $address = OrderAddress::query()
                ->create([
                    'order_id' => $order->id,
                    'cep' => $request->json('address.cep'),
                    'street' => $request->json('address.street'),
                    'number' => $request->json('address.number'),
                    'neighborhood' => $neighborhood->name,
                    'city' => $request->json('address.city'),
                    'state' => $request->json('address.state'),
                ]);
        }

        $payment = ModelsOrderPayment::query()
            ->create([
                'order_id' => $order->id,
                'type' => OrderPayment::fromValue($request->json('payment.type')),
            ]);

        $total = 0;
        foreach ($request->products as $product) {
            $model = StoreProduct::query()
                ->where('id', $product['id'])
                ->first();

            ModelsOrderProduct::query()
                ->create([
                    'order_id' => $order->id,
                    'product_id' => $model->id,
                    'value' => $model->price,
                    'amount' => $product['count'],
                    'observation' => $product['observation'],
                ]);

            $total += $model->price * $product['count'];
        }

        $order->update([
            'products_total' => $total,
            'total' => $total + $order->delivery_fee,
        ]);


        OrderCreated::dispatch($order, $customer, $payment, $address);

        DB::commit();

        return response()
            ->json([
                'message' => 'Pedido realizado com sucesso!',
                'order' => $order
            ]);
    }
}
