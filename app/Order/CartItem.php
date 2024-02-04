<?php

namespace App\Order;

use App\Product\Product;

class CartItem {

    public $product;
    public $amount;

    public function __construct(Product $product, Int $amount)
    {
        $this->product = $product;
        $this->amount = $amount;
    }

    public function getPrice()
    {
        return $this->product->getPrice() * $this->amount;
    }

    public function increaseAmount()
    {
        $this->amount++;
    }

    public function decreaseAmount()
    {
        $this->amount--;
    }
}
