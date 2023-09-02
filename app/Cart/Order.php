<?php

namespace App\Cart;

class Order {

    public static function create()
    {
        return new CreateOrder();
    }
}
