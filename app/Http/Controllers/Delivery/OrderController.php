<?php

namespace App\Http\Controllers\Delivery;

use App\Enums\Order\Delivery as OrderDelivery;
use App\Enums\Order\Payment as OrderPayment;
use App\Events\OrderCreated;
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
use App\Types\Document;
use App\Types\Name;
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
            ->setCellphone(new Cellphone($request->json('customer.cellphone')));

        if ($request->has('document')) {
            $customer->setDocument(new Document($request->json('customer.document')));
        }

        $orderBuilder = CreateOrder::make()
            ->setCustomer($customer->create())
            ->setDelivery(OrderDelivery::fromValue($request->json('delivery.type')), $request->json('delivery.observation'))
            ->setPayment(OrderPayment::fromValue($request->json('payment.type')))
            ->setAddress($request->json('address'));

        foreach ($request->products as $product) {
            $orderProduct = new OrderProduct(
                StoreProduct::find($product['id']),
                $product['count']
            );

            if (@$product['additionals'] !== null) {
                foreach ($product['additionals'] as $additional) {
                    $orderProduct->addAdditional(
                        new Additional(ProductAdditional::find($additional['id']),
                        $additional['count'])
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
