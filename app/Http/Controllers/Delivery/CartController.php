<?php

namespace App\Http\Controllers\Delivery;

use App\Cart\Cart;
use App\Cart\CartItem;
use App\Discount\Coupon;
use App\Http\Controllers\Controller;
use App\Models\Cart as ModelsCart;
use App\Models\Order;
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

        $cart = Cart::make($request->cart_id)
            ->get();

        return response()
            ->json(compact('cart'));
    }

    public function addItem(Request $request)
    {
        $cart = new Cart(ModelsCart::first());

        foreach ($request->products as $product) {
            $modelProduct = ModelsProduct::find($request->product->id);
            $classProduct = new Product($modelProduct);

            foreach ($product->additionals as $additional) {
                $classProduct->addAdditional($additional->id, $additional->amount);
            }

            foreach ($product->replacements as $replacement) {
                $classProduct->addReplacement($replacement->id);
            }

            $cart->addItem(new CartItem($classProduct, $product->amout));
        }

        return response()
            ->json([
                'message' => 'Item adicionado com sucesso'
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
