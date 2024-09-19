<?php

namespace Database\Factories;

use App\Models\StoreCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreProductFactory extends Factory
{

    public function definition()
    {
        return array_merge($this->generatePrice(), [
            'category_id' => StoreCategory::all()->random()->id,
            'name' => collect(['Fritas', 'Hamburguer Duplo', 'Hamburguer', 'Coca-Cola', 'Skol'])->random(),
            'active' => true,
            'image' => $this->faker->imageUrl(),
            'price_from' => $this->faker->boolean() ? rand(10, 50) : null,
            'price' => rand(20, 100),
            'description' => $this->faker->text(200)
        ]);
    }

    private function generatePrice()
    {
        $to = rand(20, 100);

        $from = null;
        if ($this->faker->boolean()) {
            $from = rand(10, $to);
        }

        return [
            'price_from' => $from,
            'price' => $to,
        ];
    }

}
