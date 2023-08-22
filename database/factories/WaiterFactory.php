<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WaiterFactory extends Factory
{

    public function definition()
    {
        return [
            'name' => "{$this->faker->firstName()} {$this->faker->lastName()}"
        ];
    }

}
