<?php

namespace Database\Factories;

use App\Models\StoreProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => StoreProduct::all()->random(),
            'value' => rand(10, 100),
            'amount' => rand(1, 5),
            'observation' => collect([null, 'sem cebola', 'sem tomate', 'sem ervilha'])->random(),
        ];
    }
}
