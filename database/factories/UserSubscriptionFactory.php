<?php

namespace Database\Factories;

use App\Models\PlanPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserSubscriptionFactory extends Factory
{

    public function definition()
    {
        $planPrice = PlanPrice::all()->random();

        return [
            'plan_price_id' => $planPrice->id,
            'start_at' => now()->toDateTimeString(),
            'expire_at' => now()->addMonths($planPrice->recurrence)->toDateTimeString(),
        ];
    }

}
