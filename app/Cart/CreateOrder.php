<?php

namespace App\Cart;

use App\Enums\DeliveryType;
use App\Enums\OrderOrigin;
use App\Enums\OrderStatus;
use App\Models\Customer;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\OrderDelivery;
use App\Models\OrderPayment;
use App\Models\OrderProduct;
use App\Models\OrderProductAdditional;
use App\Models\OrderProductReplacement;
use App\Product\Product;
use App\Utils\Helper;
use Illuminate\Support\Str;

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

    public function setCustomer(String $name, ?String $cpf = null, ?String $email = null)
    {
        $this->customer = [
            'name' => Helper::captalizeName($name),
            'cpf' => Helper::clearAllIsNotNumber($cpf),
            'email' => Str::lower($email)
        ];

        return $this;
    }

    public function setProduct(Product $product)
    {
        $this->products->push($product);
        return $this;
    }

    public function setPayment($type)
    {
        $this->payment = [
            'payment_type_id' => $type
        ];

        return $this;
    }

    public function setDelivery(DeliveryType $type, String $observation)
    {
        $can = Store::deliveryOptions()
            ->can($type);

        if ($can === false) {
            throw new \Exception("delivery nao permitido");
        }

        $this->delivery = [
            'type' => $type,
            'observation' => $observation
        ];

        return $this;
    }

    public function setAddress(String $street, String $number)
    {
        $this->address = [
            'street' => $street,
            'number' => $number
        ];

        return $this;
    }

    public function create()
    {
        $customer = Customer::query()
            ->create($this->customer);

        $order = Order::query()
            ->create([
                'user_store_id' => 'dwa',
                'customer_id' => $customer->id,
                'status' => OrderStatus::OPEN,
                'origin' => OrderOrigin::CUSTOMER
            ]);

        foreach ($this->products as $product) {
            OrderProduct::query()
                ->create([
                    'order_id' => $order->id,
                    'product_id' => $product->model->id,
                    'value' => $product->getValue()
                ]);

            foreach ($product->additionals as $additional) {
                OrderProductAdditional::query()
                    ->create([
                        'order_id' => $order->id,
                        'additional_id' => $additional->id,
                        'value' => $additional->getPrice()
                    ]);
            }

            foreach ($product->replacements as $replacement) {
                OrderProductReplacement::query()
                    ->create([
                        'order_id' => $order->id,
                        'value' => $replacement->getPrice()
                    ]);
            }
        }

        $delivery = OrderDelivery::query()
            ->create(array_merge($this->delivery, [
                'order_id' => $order->id
            ]));

        DeliveryAddress::query()
            ->create(array_merge($this->address, [
                'order_delivery_id' => $delivery->id,
            ]));

        OrderPayment::query()
            ->create(array_merge($this->payment, [
                'order_id' => $order->id
            ]));
    }
}
