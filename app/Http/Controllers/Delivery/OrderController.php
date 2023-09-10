<?php

namespace App\Http\Controllers\Delivery;

use App\Cart\Order;
use App\Http\Controllers\Controller;
use App\Models\StoreProduct;
use App\Models\ProductAdditional;
use App\Models\ProductReplacement;
use App\Product\Additional;
use App\Product\Product;
use App\Product\Replacement;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function create(Request $request)
    {
        $request->validate([
            'customer.name' => 'required',
            'customer.cpf' => 'required',
            'customer.email' => 'email',
            'address.street' => 'required',
            'address.number' => 'required',
            'payment.id' => 'required',
            'delivery.type' => 'required',
            'products' => 'required',
            'observation' => 'nullable|string'
        ]);

        $products = collect();
        foreach ($request->products as $product) {

            $diowjfoajfoawi = new Product(StoreProduct::find($product['id']));

            foreach ($product['additionals'] as $additional) {
                $diowjfoajfoawi->addAdditional(new Additional(ProductAdditional::find($additional['id']), $additional['amount']));
            }

            foreach ($product['replacements'] as $replacement) {
                $diowjfoajfoawi->addReplacement(new Replacement(ProductReplacement::find($replacement['id'])));
            }

            $products->push($diowjfoajfoawi);
        }

        Order::create()
            ->setCustomer($request->json('customer'))
            ->setDelivery($request->json('delivery.type'), $request->json('delivery.observation'))
            ->setAddress($request->json('address'))
            ->setPayment($request->json('payment.id'))
            ->setProducts($products)
            ->create();

        return response()
            ->json(['message' => 'Pedido realizado com sucesso!']);
    }

}
