<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\StoreCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreProductFactory extends Factory
{

    public function definition()
    {
        return [
            'store_category_id' => StoreCategory::query()->withoutGlobalScopes()->get()->random()->id,
            'name' => $this->faker->word(),
            'active' => true,
            'description' => $this->faker->text()
        ];
    }

}
