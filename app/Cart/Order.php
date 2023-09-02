<?php

namespace App\Cart;

class Order {

    public static function make()
    {
        return new CreateOrder();
    }
}
