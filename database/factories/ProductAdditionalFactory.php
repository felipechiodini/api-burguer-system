<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductAdditionalFactory extends Factory
{

    public function definition()
    {
        return [
            'name' => $this->faker->word(5),
            'value' => $this->faker->numberBetween(1, 26),
            'max' => 5
        ];
    }

}
