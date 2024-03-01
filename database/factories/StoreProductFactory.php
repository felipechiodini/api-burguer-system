<?php

namespace Database\Factories;

use App\Models\StoreCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreProductFactory extends Factory
{

    public function definition()
    {
        return [
            'store_category_id' => StoreCategory::all()->random()->id,
            'name' => collect(['Fritas', 'Hamburguer Duplo', 'Hamburguer', 'Coca-Cola', 'Skol'])->random(),
            'active' => true,
            'price_from' => rand(50,100),
            'price_to' => rand(0,50),
            'description' => $this->faker->text(200)
        ];
    }

}
