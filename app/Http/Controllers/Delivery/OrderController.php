<?php

namespace App\Http\Controllers\Delivery;

use App\Cart\CreateCustomer;
use App\Cart\CreateOrder;
use App\Http\Controllers\Controller;
use App\Models\StoreProduct;
use App\Models\ProductAdditional;
use App\Models\ProductReplacement;
use App\Order\Additional;
use App\Order\OrderProduct;
use App\Order\Replacement;
use App\Types\Cellphone;
use App\Types\Document;
use App\Types\Name;
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

        $customer = CreateCustomer::make()
            ->setName(new Name($request->json('customer.name')))
            ->setDocument(new Document($request->json('customer.document')))
            ->setCellphone(new Cellphone($request->json('customer.cellphone')))
            ->create();

        $orderBuilder = CreateOrder::make()
            ->setCustomer($customer)
            ->setDelivery($request->json('delivery.type'), $request->json('delivery.observation'))
            ->setAddress($request->json('address'))
            ->setPayment($request->json('payment.id'));

        foreach ($request->products as $product) {
            $orderProduct = new OrderProduct(
                StoreProduct::find($product['id']),
                $product['amount']
            );

            foreach ($product['additionals'] as $additional) {
                $orderProduct->addAdditional(
                    new Additional(ProductAdditional::find($additional['id']),
                    $additional['amount'])
                );
            }

            foreach ($product['replacements'] as $replacement) {
                $orderProduct->addReplacement(
                    new Replacement(ProductReplacement::find($replacement['id']))
                );
            }

            $orderBuilder->addProduct($product);
        }

        $orderBuilder->create();

        return response()
            ->json(['message' => 'Pedido realizado com sucesso!']);
    }
}
