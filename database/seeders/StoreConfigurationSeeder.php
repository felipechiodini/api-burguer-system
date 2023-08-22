<?php

namespace Database\Seeders;

use App\Models\StoreConfiguration;
use App\Models\UserStore;
use Illuminate\Database\Seeder;

class StoreConfigurationSeeder extends Seeder
{

    public function run()
    {
        UserStore::all()->each(function(UserStore $store) {
            StoreConfiguration::create([
                'user_store_id' => $store->id,
                'warning' => null,
                'allow_withdrawal' => 1,
                'withdrawal_time' => 20,
                'delivery_time' => 30,
                'minimum_order_value' => 25,
                'delivery_price_per_km' => 1.5
            ]);
        });
    }

}
