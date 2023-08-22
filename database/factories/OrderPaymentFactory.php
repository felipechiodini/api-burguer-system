<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderPaymentFactory extends Factory
{

    public function definition()
    {
        return [
            'value' => $this->faker->numberBetween(10, 500)
        ];
    }

}
