<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductConfigurationFactory extends Factory
{

    public function definition()
    {
        return [
            'warning' => null,
            'minimum_order_value' => rand(10, 50),
        ];
    }

}
