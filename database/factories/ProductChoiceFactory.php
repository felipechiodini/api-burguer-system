<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductChoiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'quantity' => rand(1, 5),
            'required' => $this->faker->boolean(),
        ];
    }
}
