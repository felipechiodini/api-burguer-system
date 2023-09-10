<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StoreCategoryFactory extends Factory
{

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'order' => rand(1, 10)
        ];
    }

}
