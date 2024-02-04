<?php

namespace App\Order;

class DeliveryOptions {

    private $options;

    public static function load()
    {
        return new static([1]);
    }

    public function __construct(Array $options)
    {
        $this->options = $options;
    }

    public function can($type)
    {
        return in_array($this->options, $type);
    }
}
