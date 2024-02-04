<?php

namespace App\Http\Controllers\Delivery;

use App\Order\CreateCustomer;
use App\Order\CreateOrder;
use App\Http\Controllers\Controller;
use App\Models\StoreProduct;
use App\Models\ProductAdditional;
use App\Models\ProductReplacement;
use App\Order\Additional;
use App\Order\OrderProduct;
use App\Order\Replacement;
use App\Types\Cellphone;
use App\Types\Delivery;
use App\Types\Document;
use App\Types\Name;
use App\Types\Payment;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function create(Request $request)
    {
        $request->validate([
            'customer.name' => 'required',
            'customer.document' => '',
            'customer.cellphone' => 'required',
            'address.street' => 'required',
            'address.number' => 'required',
            'payment.type' => 'required',
            'delivery.type' => 'required',
            'delivery.observation' => 'string',
            'products' => 'required',
        ]);

        $customer = CreateCustomer::make()
            ->setName(new Name($request->json('customer.name')))
            ->setDocument(new Document($request->json('customer.document')))
            ->setCellphone(new Cellphone($request->json('customer.cellphone')))
            ->create();

        $orderBuilder = CreateOrder::make()
            ->setCustomer($customer)
            ->setDelivery(new Delivery($request->json('delivery.type')), $request->json('delivery.observation'))
            ->setPayment(new Payment($request->json('payment.type')));

        foreach ($request->products as $product) {
            $orderProduct = new OrderProduct(
                StoreProduct::find($product['id']),
                $product['amount']
            );

            if (@$product['additionals'] !== null) {
                foreach ($product['additionals'] as $additional) {
                    $orderProduct->addAdditional(
                        new Additional(ProductAdditional::find($additional['id']),
                        $additional['amount'])
                    );
                }
            }

            if (@$product['replacements'] !== null) {
                foreach ($product['replacements'] as $replacement) {
                    $orderProduct->addReplacement(
                        new Replacement(ProductReplacement::find($replacement['id']))
                    );
                }
            }

            $orderBuilder->addProduct($orderProduct);
        }

        $orderBuilder->create();

        return response()
            ->json(['message' => 'Pedido realizado com sucesso!']);
    }

}
