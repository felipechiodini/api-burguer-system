<?php

namespace Database\Factories;

use App\Enums\Order\Origin;
use App\Enums\Order\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreOrderFactory extends Factory
{

    public function definition()
    {
        return [
            'store_customer_id' => 1,
            'status' => Status::OPEN,
            'origin' => Origin::APP,
            'products_total' => 100,
            'delivery_fee' => 10,
            'discount' => 10,
            'total' => 100,
        ];
    }

}
