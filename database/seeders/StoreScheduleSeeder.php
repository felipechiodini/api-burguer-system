<?php

namespace Database\Seeders;

use App\Models\StoreSchedule;
use App\Models\UserStore;
use Illuminate\Database\Seeder;

class StoreScheduleSeeder extends Seeder
{

    public function run()
    {
        UserStore::each(function(UserStore $store) {
            for ($i = 0; $i < 7; $i++) {
                StoreSchedule::create([
                    'store_id' => $store->id,
                    'week_day' => $i,
                    'open_at' => '18:00:00',
                    'close_at' => '23:00:00',
                    'closed' => 0
                ]);
            }
        });
    }

}
