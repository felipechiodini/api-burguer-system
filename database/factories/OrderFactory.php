<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{

    public function definition()
    {
        return [
            'store_card_id' => null,
            'customer_id' => Customer::withoutGlobalScopes()->get()->random()->id,
            'type' => 'delivery',
            'status' => 'open',
            // 'coupon_id' => null,
            'origin' => 'app'
        ];
    }

}
