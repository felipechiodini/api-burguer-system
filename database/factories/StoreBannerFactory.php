<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StoreBannerFactory extends Factory
{

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'src' => 'https://s3.amazonaws.com/assets-fluminense/posts/8403/POST-FLU_SITE_%C3%9Anico_-1280-x-720_banner.jpg',
            'order' => $this->faker->numberBetween(1, 10)
        ];
    }

}
