<?php

namespace Database\Factories;

use App\Enums\OrderOrigin;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreOrderFactory extends Factory
{

    public function definition()
    {
        return [
            'store_customer_id' => 1,
            'status' => OrderStatus::OPEN,
            'origin' => OrderOrigin::CUSTOMER
        ];
    }

}
