<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserStoreFactory extends Factory
{

    public function definition()
    {
        return [
            'user_id' => 1,
            'name' => 'Plankton Burguer',
            'slug' => 'plankton',
        ];
    }

}
