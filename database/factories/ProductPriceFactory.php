<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductPriceFactory extends Factory
{

    public function definition()
    {
        return [
            'value' => $this->faker->numberBetween(3, 120),
            'start_date' => now()->toDateTimeString(),
            'end_date' => now()->addMonths(1)->toDateTimeString()
        ];
    }

}
