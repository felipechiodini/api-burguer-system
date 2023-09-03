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
use App\Utils\Helper;
use Illuminate\Support\Collection;
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
            'document' => Helper::clearAllIsNotNumber($cpf),
            'email' => Str::lower($email),
            'cellphone' => '47999097073'
        ];

        return $this;
    }

    public function setProducts(Collection $products)
    {
        $this->products = $products;
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

    public function setAddress(String $street, String $number)
    {
        $this->address = [
            'cep' => 'dwadawd',
            'street' => 'dwadawd',
            'number' => 'dwadawd',
            'district' => 'dwadawd',
            'city' => 'dwadawd',
            'state' => 'dwadawd',
            'latitude' => 'dwadawd',
            'longitude' => 'dwadawd',
        ];

        return $this;
    }

    public function create()
    {
        $customer = Customer::query()
            ->create(array_merge($this->customer, [
                'user_store_id' => '18d61b11-2f3e-34db-93ad-6e3692cac7e8',
            ]));

        $order = Order::query()
            ->create([
                'user_store_id' => '18d61b11-2f3e-34db-93ad-6e3692cac7e8',
                'customer_id' => $customer->id,
                'status' => OrderStatus::OPEN,
                'origin' => OrderOrigin::CUSTOMER
            ]);

        foreach ($this->products as $product) {
            OrderProduct::query()
                ->create([
                    'order_id' => $order->id,
                    'product_id' => $product->model->id,
                    'amount' => $product->amount,
                    'value' => $product->getValue()
                ]);

            foreach ($product->additionals as $additional) {
                OrderProductAdditional::query()
                    ->create([
                        'order_id' => $order->id,
                        'product_additional_id' => $additional->model->id,
                        'value' => $additional->getValue(),
                        'amount' => 2
                    ]);
            }

            foreach ($product->replacements as $replacement) {
                OrderProductReplacement::query()
                    ->create([
                        'order_id' => $order->id,
                        'replacement_id' => $replacement->model->id,
                        'value' => $replacement->getValue()
                    ]);
            }
        }

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
