<?php

namespace App\Order;

use App\Enums\Order\Delivery as EnumsOrderDelivery;
use App\Enums\Order\Origin;
use App\Enums\Order\Payment as EnumsOrderPayment;
use App\Enums\Order\Status;
use App\Events\OrderCreated;
use App\Models\DeliveryAddress;
use App\Models\OrderDelivery;
use App\Models\OrderPayment;
use App\Models\OrderProduct as ModelsOrderProduct;
use App\Models\OrderProductAdditional;
use App\Models\OrderProductReplacement;
use App\Models\StoreCustomer;
use App\Models\StoreOrder;
use App\Order\Additional;
use App\Order\OrderProduct;
use App\Order\Replacement;
use App\Types\Delivery;
use App\Types\Payment;

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

    public function setDelivery(EnumsOrderDelivery $type, ?String $observation)
    {
        $this->delivery = [
            'type' => $type,
            'observation' => $observation
        ];

        return $this;
    }

    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    public function setPayment(EnumsOrderPayment $type)
    {
        $this->payment = [
            'type' => $type
        ];

        return $this;
    }

    public function addProduct(OrderProduct $product)
    {
        $this->products->push($product);
        return $this;
    }

    public function create()
    {
        $deliveryFee = $this->getDeliveryFee();

        $total = $this->products->reduce(fn($accumulator, $aaaaaa) => $accumulator += $aaaaaa->getValue());

        $order = StoreOrder::query()
            ->create([
                'customer_id' => $this->customer->id,
                'status' => Status::OPEN,
                'origin' => Origin::APP,
                'products_total' => $total,
                'delivery_fee' => $deliveryFee,
                'discount' => 0,
                'total' => $total + $deliveryFee,
            ]);

        $this->products->each(function(OrderProduct $product) use($order, $total) {
            $total += $product->getValue();

            ModelsOrderProduct::query()
                ->create([
                    'store_order_id' => $order->id,
                    'product_id' => $product->model->id,
                    'value' => $product->getValue(),
                    'amount' => $product->amount,
                    'observation' => $product->observation
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
                'store_order_id' => $order->id
            ]));

        if ($this->delivery['type']->value === EnumsOrderDelivery::DELIVERY) {
            $address = DeliveryAddress::query()
                ->create(array_merge($this->address, [
                    'neighborhood' => "dkawdwa",
                    'order_delivery_id' => $delivery->id,
                    'city' => 'wdadwa'
                ]));
        }

        $payment = OrderPayment::query()
            ->create(array_merge($this->payment, [
                'store_order_id' => $order->id
            ]));

        OrderCreated::dispatch($order, $this->customer, $payment, @$address);

        return $order;
    }

    private function getDeliveryFee()
    {
        return 10;
    }

}
