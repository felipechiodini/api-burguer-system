<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductPhotoFactory extends Factory
{

    public function definition()
    {
        return [
            'src' => 'https://storage.googleapis.com/intrepid-snow-169619.appspot.com/files/backend/66011019248D4F91AEDB6C5CD60F82A0-0E9B5825CD664072870992304367C312.jpeg',
            'order' => $this->faker->numberBetween(1, 10)
        ];
    }

}
