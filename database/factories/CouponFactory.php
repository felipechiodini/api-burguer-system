<?php

namespace Database\Factories;

use App\Enums\CouponType;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'code' => 'CODE' . $this->faker->numberBetween(1, 10000),
            'value' => $this->faker->numberBetween(1, 100),
            'type' => $this->faker->boolean() ? CouponType::PERCENT : CouponType::UNIT
        ];
    }

}
