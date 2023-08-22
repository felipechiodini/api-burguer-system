<?php

namespace App\Http\Controllers\Delivery;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderPayment;
use App\Models\Product;
use App\Models\SubOrder;
use App\Models\UserStore;
use App\Product\CalculatePriceProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $customer = Customer::firstOrCreate([
                'user_store_id' => $request->header(UserStore::HEADER_KEY),
                'document' => $request->json('customer.document'),
            ], [
                'name' => $request->json('customer.name'),
                'cellphone' => $request->json('customer.cellphone')
            ]);

            $order = Order::create([
                'user_store_id' => $request->header(UserStore::HEADER_KEY),
                'customer_id' => $customer->id,
                'type' => $request->input('type'),
                'status' => OrderStatus::OPEN,
                'origin' => 'app',
            ]);

            OrderAddress::create([
                'order_id' => $order->id,
                'name' => $request->json('address.name'),
                'cep' => $request->json('address.cep'),
                'state' => $request->json('address.state'),
                'city' => $request->json('address.city'),
                'street' => $request->json('address.street'),
                'number' => $request->json('address.number'),
                'complement' => $request->json('address.complement'),
            ]);

            $subOrder = SubOrder::create([
                'order_id' => $order->id
            ]);

            foreach ($request->json('products') as $product) {
                $modelProduct = Product::find($product['id']);

                $priceProduct = CalculatePriceProduct::product($modelProduct)
                    ->replacements($product['replacements'])
                    ->additionals($product['additionals'])
                    ->getPrice();

                $subOrder->products()->attach($product['id'], [
                    'value' => $priceProduct,
                    'amount' => $product['count'],
                    'observation' => $product['observation']
                ]);
            }

            OrderPayment::create([
                'order_id' => $order->id,
                'payment_type_id' => $request->json('payment.type'),
            ]);

            DB::commit();

            return response()->json(['message' => 'Pedido criado com sucesso!'], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ], 500);
        }
    }

}
