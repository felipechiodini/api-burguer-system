<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{

    public function run()
    {
        Module::factory()->count(10)->create();
    }

}
