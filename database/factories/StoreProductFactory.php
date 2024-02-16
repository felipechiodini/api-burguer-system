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
            'price_from' => 200,
            'price_to' => 100,
            'description' => $this->faker->text(200)
        ];
    }

}
