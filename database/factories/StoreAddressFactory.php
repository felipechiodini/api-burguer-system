<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StoreAddressFactory extends Factory
{

    public function definition(): array
    {
        return [
            'street' => 'Arthur Gonçalves de Araújo',
            'number' => 500,
            'neighborhood' => 'João Pessoa',
            'city' => 'Jaraguá do Sul',
            'state' => 'SC',
            'cep' => '89253390',
            'latitude' => -26.5055932,
            'longitude' => -49.0971134
        ];
    }

}
