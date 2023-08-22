<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{

    public function definition()
    {
        return [
            'category_id' => Category::all('id')->random()->id,
            'name' => $this->faker->word(),
            'description' => $this->faker->text()
        ];
    }

}
