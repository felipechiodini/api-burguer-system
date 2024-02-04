<?php

namespace App\Order;

use App\Enums\OrderOrigin;
use App\Enums\OrderStatus;
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

    public function setDelivery(Delivery $type, String $observation)
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

    public function setPayment(Payment $type)
    {
        $this->payment = [
            'payment_type_id' => $type
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
        $order = StoreOrder::query()
            ->create([
                'user_store_id' => 1,
                'store_customer_id' => $this->customer->id,
                'status' => OrderStatus::OPEN,
                'origin' => OrderOrigin::APP
            ]);

        $this->products
            ->each(function(OrderProduct $product) use($order) {
                ModelsOrderProduct::query()
                    ->create([
                        'store_order_id' => $order->id,
                        'store_product_id' => $product->model->id,
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

        DeliveryAddress::query()
            ->create(array_merge($this->address, [
                'delivery_id' => $delivery->id
            ]));

        OrderPayment::query()
            ->create(array_merge($this->payment, [
                'store_order_id' => $order->id
            ]));
    }

}
