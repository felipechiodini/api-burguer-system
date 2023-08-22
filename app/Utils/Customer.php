<?php

namespace App\Utils;

use App\Cart\Cart as CartCart;
use App\Models\Cart;
use App\Models\Customer as ModelsCustomer;

class Customer {

    public $model;

    public function __construct(ModelsCustomer $customer)
    {
        $this->model = $customer;
    }

    public function getCurrentCart()
    {
        $cart = Cart::query()
            ->where('customer_id', $this->model->id)
            ->firstOrCreate([
                'customer_id' => $this->model->id
            ]);

        return new CartCart($cart);
    }
}
