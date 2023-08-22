<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{

    public function definition()
    {
        return [
            'name' => 'Felipe Chiodini Bona',
            'email' => 'felipechiodinibona@hotmail.com',
            'cellphone' => '47999097073',
            'password' => Hash::make('132567'),
        ];
    }

}
