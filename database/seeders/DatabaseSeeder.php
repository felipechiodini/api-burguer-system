<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call([
            // ModuleSeeder::class,
            // PlanSeeder::class,
            PaymentTypeSeeder::class,
            UserSeeder::class,
            // StoreScheduleSeeder::class,
            StoreConfigurationSeeder::class
        ]);
    }

}
