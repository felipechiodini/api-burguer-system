<?php

namespace App\Order;

use App\Models\ProductAdditional;

class Additional {

    public $model;
    public $amount;

    public function __construct(ProductAdditional $additional, Int $amount)
    {
        $this->model = $additional;
        $this->amount = $amount;
    }

    public function getValue()
    {
        return $this->model->value * $this->amount;
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
