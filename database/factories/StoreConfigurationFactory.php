<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StoreConfigurationFactory extends Factory
{

    public function definition()
    {
        return [
            'unit_type' => 'grams',
            'max_number_replacements' => 3,
            'max_number_additionals' => 3,
        ];
    }

}
