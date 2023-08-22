<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductReplacementFactory extends Factory
{

    public function definition()
    {
        return [
            'name' => $this->faker->word(5),
            'value' => $this->faker->numberBetween(1, 26),
        ];
    }

}
