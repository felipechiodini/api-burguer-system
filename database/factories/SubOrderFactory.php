<?php

namespace Database\Factories;

use App\Models\Waiter;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubOrderFactory extends Factory
{

    public function definition()
    {
        return [
            // 'store_waiter_id' => Waiter::all('id')->random()->id
        ];
    }

}
