<?php

namespace Database\Seeders;

use App\Models\StoreAddress;
use App\Models\UserStore;
use Illuminate\Database\Seeder;

class StoreAddressSeeder extends Seeder
{

    public function run()
    {
        UserStore::each(function(UserStore $store) {
            StoreAddress::create([
                'user_store_id' => $store->id,
                'street' => 'Arthur Gonçalves de Araújo',
                'number' => 500,
                'district' => 'João Pessoa',
                'city' => 'Jaraguá do Sul',
                'state' => 'SC',
                'cep' => '89253390',
                'latitude' => -26.5055932,
                'longitude' => -49.0971134,
            ]);
        });
    }

}
