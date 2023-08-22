<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\PlanPrice;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{

    public function run()
    {
        $basic = Plan::create(['name' => 'Básico', 'description' => Lorem::paragraph(), 'foreing_id' => 'basic_plan']);
        $advanced = Plan::create(['name' => 'Avançado', 'description' => Lorem::paragraph(), 'foreing_id' => 'basic_plan']);
        $pro = Plan::create(['name' => 'Pro', 'description' => Lorem::paragraph(), 'foreing_id' => 'basic_plan']);

        $basic->modules()->attach(range(1,10));
        $advanced->modules()->attach(range(1,10));
        $pro->modules()->attach(range(1,10));

        PlanPrice::create(['plan_id' => 1, 'recurrence' => 1, 'value' => 10]);
        PlanPrice::create(['plan_id' => 2, 'recurrence' => 1, 'value' => 50]);
        PlanPrice::create(['plan_id' => 3, 'recurrence' => 1, 'value' => 100]);

        PlanPrice::create(['plan_id' => 1, 'recurrence' => 6, 'value' => 60]);
        PlanPrice::create(['plan_id' => 2, 'recurrence' => 6, 'value' => 300]);
        PlanPrice::create(['plan_id' => 3, 'recurrence' => 6, 'value' => 1200]);

        PlanPrice::create(['plan_id' => 1, 'recurrence' => 12, 'value' => 120]);
        PlanPrice::create(['plan_id' => 2, 'recurrence' => 12, 'value' => 600]);
        PlanPrice::create(['plan_id' => 3, 'recurrence' => 12, 'value' => 2400]);
    }

}
