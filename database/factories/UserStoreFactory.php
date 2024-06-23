<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserStoreFactory extends Factory
{

    public function definition()
    {
        return [
            'logo' => $this->faker->imageUrl(),
            'banner' => $this->faker->imageUrl()
        ];
    }

}
