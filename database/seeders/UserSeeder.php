<?php

namespace Database\Seeders;

use App\Models\StoreBanner;
use App\Models\StoreOrder;
use App\Models\ProductAdditional;
use App\Models\ProductConfiguration;
use App\Models\ProductPhoto;
use App\Models\ProductPrice;
use App\Models\ProductReplacement;
use App\Models\StoreCategory;
use App\Models\StoreCustomer;
use App\Models\StoreDeliveryType;
use App\Models\StorePaymentType;
use App\Models\StoreProduct;
use App\Models\User;
use App\Models\UserStore;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run()
    {
        User::factory()
            ->count(1)
            ->has(
                UserStore::factory()
                    ->state(new Sequence(
                        ['name' => 'Plankton Burguer', 'slug' => 'plankton'],
                        ['name' => 'Bona Burguer', 'slug' => 'bona'],
                    ))
                    ->has(StoreBanner::factory()->count(3), 'banners')
                    ->has(StoreCategory::factory()->count(10), 'categories')
                    ->has(StoreProduct::factory()
                        ->has(ProductPrice::factory()->count(1), 'prices')
                        ->has(ProductConfiguration::factory()->count(1), 'configuration')
                        ->has(ProductPhoto::factory()->count(3), 'photos')
                        ->has(ProductAdditional::factory()->count(3), 'additionals')
                        ->has(ProductReplacement::factory()->count(3), 'replacements')
                            ->count(30), 'products')
                    ->has(StoreCustomer::factory()->count(30), 'customers')
                        ->count(2), 'stores')
                    ->create();

        StorePaymentType::query()
            ->create([
                'user_store_id' => 1,
                'payment_type_id' => 'pix'
            ]);

        StoreDeliveryType::query()
            ->create([
                'user_store_id' => 1,
                'delivery_type_id' => 'delivery'
            ]);

        StorePaymentType::query()
            ->create([
                'user_store_id' => 2,
                'payment_type_id' => 'pix'
            ]);

        StoreDeliveryType::query()
            ->create([
                'user_store_id' => 2,
                'delivery_type_id' => 'delivery'
            ]);

        StoreOrder::factory()
            ->count(50)
            ->create([
                'user_store_id' => UserStore::first()->id
            ]);
    }

}
