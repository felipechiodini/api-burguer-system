<?php

namespace App\Http\Controllers\Delivery;

use App\Cart\Order;
use App\Enums\DeliveryType;
use App\Http\Controllers\Controller;
use App\Models\Product as ModelsProduct;
use App\Product\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function finish(Request $request)
    {
        $request->validate([
            'customer.name' => 'required',
            'customer.cpf' => 'cpf',
            'customer.email' => 'email',
            'address.street' => 'required',
            'address.number' => 'required',
            'payment.id' => 'required',
            'delivery.type' => 'required',
            'products' => 'required',
            'observation' => 'nullable|string'
        ]);

        $product = new Product(ModelsProduct::query()->first());

        Order::create()
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
