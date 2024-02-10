<?php

namespace Database\Factories;

use App\Enums\Order\Delivery;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDeliveryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => Delivery::getRandomValue()
        ];
    }
}
