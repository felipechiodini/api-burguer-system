<?php

namespace App\Cart;

use App\Discount\DiscountInterface;
use App\Models\Cart as ModelsCart;
use App\Models\Order;
use App\Product\Product;

class Cart {

    public $model;
    public $items;
    public $discount;
    public $payment;
    public $address;

    public function __construct(ModelsCart $cart)
    {
        $this->model = $cart;
        $this->items = collect([]);
    }

    public function getShippingPrice()
    {
        return 10;
    }

    public function getSubtotal()
    {
        $price = 0;

        foreach ($this->items as $item) {
            $price += $item->getPrice();
        }

        return $price;
    }

    public function getDiscount()
    {
        if ($this->discount->getType() === 'percent') {
            return ($this->discount->getValue() / 100) * $this->getSubtotal();
        } else {
            return $this->discount->getValue();
        }
    }

    public function getTotal()
    {
        return $this->getSubtotal() + $this->getShippingPrice() - $this->getDiscount();
    }

    public function addDiscount(DiscountInterface $discount)
    {
        $this->discount = $discount;
    }

    public function addAddress($address)
    {
        $this->address = $address;
    }

    public function addPayment($payment)
    {
        $this->payment = $payment;
    }

    public function addItem(CartItem $cartitem)
    {
        $this->items->push($cartitem);
    }

    public function finish()
    {
        $order = Order::query()
            ->create([
                'dwad' => 'dwads',
            ]);

        $order->payment()
            ->create([
                'dwa' => 'dwa'
            ]);
    }
}
