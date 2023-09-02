<?php

namespace App\Cart;

class Store {

    public static function deliveryOptions()
    {
        return DeliveryOptions::load();
    }

    public static function paymentMethods()
    {
        return paymentMethods::load();
    }

    public static function isOpen()
    {
        return true;
    }
}
