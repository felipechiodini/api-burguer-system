<?php

namespace App\Http\Controllers\Delivery;

use App\Cart\Cart;
use App\Cart\Order;
use App\Enums\DeliveryType;
use App\Http\Controllers\Controller;
use App\Models\Cart as ModelsCart;
use App\Models\CartItem;
use App\Models\Coupon as ModelsCoupon;
use App\Models\Product as ModelsProduct;
use App\Product\Product;
use Illuminate\Http\Request;

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

        $product = new Product(ModelsProduct::query()->first());

        Order::make()
            ->setCustomer($request->customer->name)
            ->setAddress($request->address->street, $request->address->number)
            ->setDelivery(DeliveryType::fromValue($request->delivery->type), $request->delivery->observation)
            ->setPayment($request->payment->id)
            ->setProduct($product)
            ->create();

        return response()
            ->json(['message' => 'Pedido realizado com sucesso!']);
    }
}
