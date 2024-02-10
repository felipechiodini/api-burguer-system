<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderAddressFactory extends Factory
{
    public function definition(): array
    {
        return $this->getCity();
    }

    private function getCity()
    {
        return collect([
            [
                'cep' => '89257550',
                'street' => 'Arthur Gonçalvez de Araújo',
                'number' => 500,
                'city' => 'Jaraguá do Sul',
                'neighborhood' => 'João Pessoa',
                'complement' => 'Bloco Safira AP 606'
            ],
            [
                'cep' => '89253390',
                'street' => 'Cléco Stringari',
                'number' => 45,
                'city' => 'Jaraguá do Sul',
                'neighborhood' => 'Jaraguá Esquerdo'
            ]
        ])->random();
    }
}
