<?php

namespace App\Http\Controllers\Delivery;

use App\Cart\Cart;
use App\Discount\Coupon;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function get(Request $request)
    {
        $request->validate([
            'cart_id' => 'exists:carts,id'
        ]);

        $cart = Cart::make($request->cart_id)
            ->get();

        return response()
            ->json(compact('cart'));
    }

    public function addItem(Request $request)
    {
        $request->validate([
            'cart_id' => 'exists:carts,id',
            'item_id' => 'exists:product_items,id',
            'amount' => 'integer'
        ]);

        Cart::make($request->cart_id)
            ->add($request->item_id, $request->input('amount', 1));

        return response()
            ->json([
                'message' => 'Item adicionado com sucesso!'
            ]);
    }

    public function addCoupon(Request $request)
    {
        $request->validate([
            'cart_id' => 'exists:carts,id',
            'coupon' => 'exists:coupons,code'
        ]);

        Cart::make($request->cart_id)
            ->addDiscount(Coupon::make($request->coupon));

        return response()
            ->json([
                'message' => 'Desconto adicionado!'
            ]);
    }

    public function finish(Request $request)
    {
        $request->validate([
            'cart_id' => 'exists:carts,id'
        ]);

        Order::query()
            ->create([
                'user_id' => 'dwads',
                'total' => 'dwads'
            ]);

    }
}
