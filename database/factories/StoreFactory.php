<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{

    public function definition()
    {
        return [
            'name' => 'Plankton Burguer',
            'slug' => 'plankton',
            'logo' => 'aaaaaaaaa'
        ];
    }

}
