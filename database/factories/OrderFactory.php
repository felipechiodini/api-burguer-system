<?php

namespace Database\Factories;

use App\Enums\OrderOrigin;
use App\Enums\OrderStatus;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{

    public function definition()
    {
        return [
            'store_card_id' => null,
            'customer_id' => Customer::withoutGlobalScopes()->get()->random()->id,
            'status' => OrderStatus::OPEN,
            'origin' => OrderOrigin::CUSTOMER
        ];
    }

}
