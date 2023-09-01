<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Cart as ModelsCart;
use App\Models\Coupon as ModelsCoupon;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\OrderDelivery;
use App\Models\OrderPayment;
use App\Models\Product as ModelsProduct;
use App\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{

    public function get(Request $request)
    {
        $request->validate([
            'cart_id' => 'exists:carts,id'
        ]);

        $cart = (ModelsCart::find($request->cart_id))
            ->serialize();

        return response()
            ->json(compact('cart'));
    }

    public function addItem(Request $request)
    {
        $request->validate([
            'cart_id' => 'required'
        ]);

        $cart = ModelsCart::find($request->cart_id);

        foreach ($request->products as $product) {
            $cart->addItem(
                new Product(ModelsProduct::find($product['id'])),
                $product['amount'],
                $product->observation ?? null
            );
        }

        return response()
            ->json(['message' => 'Item adicionado com sucesso!']);
    }

    public function removeItem(Request $request)
    {
        $request->validate([
            'cart_id' => 'required',
            'item_id' => 'required'
        ]);

        $cart = ModelsCart::find($request->cart_id);

        $cart->items()
            ->find($request->id)
            ->delete();

        return response()
            ->json(['message' => 'Item adicionado com sucesso!']);
    }

    public function addCoupon(Request $request)
    {
        $request->validate([
            'cart_id' => 'required',
            'code' => 'required|string'
        ]);

        $cart = ModelsCart::find($request->cart_id);

        $cart->addCoupon(ModelsCoupon::getByCode($request->code));

        return response()
            ->json(['message' => 'Desconto adicionado!']);
    }

    public function finish(Request $request)
    {
        $request->validate([
            'cart_id' => 'required',
            'observation' => 'nullable|string'
        ]);

        $order = Order::query()
            ->create([
                'user_id' => 'dwads',
                'total' => 'dwads'
            ]);

        $address = DeliveryAddress::query()
            ->create([
                'street' => $request->address->street
            ]);

        OrderDelivery::query()
            ->create([
                'order_id' => $order->id,
                'delivery_address_id' => $address->id,
                'type' => $request->delivery->type,
                'observation' => $request->delivery->observation
            ]);

        OrderPayment::query()
            ->create([
                'order_id' => $order->id,
                'payment_type_id' => $request->payment_type_id
            ]);

        return response()
            ->json(['message' => 'Pedido realizado com sucesso!']);
    }
}
