<?php

namespace App\Cart;

use App\Enums\OrderOrigin;
use App\Enums\OrderStatus;
use App\Models\DeliveryAddress;
use App\Models\OrderDelivery;
use App\Models\OrderPayment;
use App\Models\OrderProduct;
use App\Models\OrderProductAdditional;
use App\Models\OrderProductReplacement;
use App\Models\StoreCustomer;
use App\Models\StoreOrder;
use App\Order\Additional;
use App\Order\OrderProduct as OrderOrderProduct;
use App\Order\Replacement;

class CreateOrder {

    private $customer;
    private $products;
    private $delivery;
    private $address;
    private $payment;

    public function __construct()
    {
        $this->products = collect([]);
    }

    public static function make()
    {
        return new static();
    }

    public function setCustomer(StoreCustomer $customer)
    {
        $this->customer = $customer;
        return $this;
    }

    public function setPayment($type)
    {
        $this->payment = [
            'payment_type_id' => $type
        ];

        return $this;
    }

    public function setDelivery($type, ?String $observation = null)
    {
        $this->delivery = [
            'type' => $type,
            'observation' => $observation
        ];

        return $this;
    }

    public function setAddress($address)
    {
        $this->address = [
            'street' => $address['street'],
            'number' => $address['number'],
        ];

        return $this;
    }

    public function addProduct(OrderOrderProduct $product)
    {
        $this->products->push($product);
        return $this;
    }

    public function create()
    {
        $order = StoreOrder::query()
            ->create([
                'user_store_id' => '18d61b11-2f3e-34db-93ad-6e3692cac7e8',
                'customer_id' => $this->customer->id,
                'status' => OrderStatus::OPEN,
                'origin' => OrderOrigin::APP
            ]);

        $this->products
            ->each(function(OrderOrderProduct $product) use($order) {
                OrderProduct::query()
                    ->create([
                        'order_id' => $order->id,
                        'product_id' => $product->model->id,
                        'amount' => $product->amount,
                        'value' => $product->getValue()
                    ]);

                $product->additionals
                    ->each(function(Additional $additional) use($product) {
                        OrderProductAdditional::query()
                            ->create([
                                'order_product_id' => $product->model->id,
                                'product_additional_id' => $additional->model->id,
                                'value' => $additional->getValue(),
                                'amount' => $additional->amount
                            ]);
                    });

                $product->replacements
                    ->each(function(Replacement $replacement) use($product) {
                        OrderProductReplacement::query()
                            ->create([
                                'order_product_id' => $product->model->id,
                                'product_replacement_id' => $replacement->model->id,
                                'value' => $replacement->getValue()
                            ]);
                });
            });

        $delivery = OrderDelivery::query()
            ->create(array_merge($this->delivery, [
                'order_id' => $order->id
            ]));

        DeliveryAddress::query()
            ->create(array_merge($this->address, [
                'delivery_id' => $delivery->id
            ]));

        OrderPayment::query()
            ->create(array_merge($this->payment, [
                'order_id' => $order->id
            ]));
    }

}
