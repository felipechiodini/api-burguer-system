<?php

namespace Database\Seeders;

use App\Models\StoreBanner;
use App\Models\Card;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\Product;
use App\Models\ProductAdditional;
use App\Models\ProductConfiguration;
use App\Models\ProductPhoto;
use App\Models\ProductPrice;
use App\Models\ProductReplacement;
use App\Models\SubOrder;
use App\Models\User;
use App\Models\UserStore;
use App\Models\UserSubscription;
use App\Models\Waiter;
use Illuminate\Database\Seeder;
use Spatie\Multitenancy\Models\Tenant;

class UserSeeder extends Seeder
{

    public function run()
    {
        Tenant::query()
            ->create([
                'name' => 'Plankton Burguer',
                'domain' => 'plankton.burguersytem.local',
                'database' => 'hamburguer_api',
            ]);

        User::factory()
            ->count(1)
            ->has(
                UserStore::factory()
                    ->has(StoreBanner::factory()->count(3), 'banners')
                    ->has(Category::factory()->count(10), 'categories')
                    ->has(Product::factory()
                        ->has(ProductPrice::factory()->count(1), 'prices')
                        ->has(ProductConfiguration::factory()->count(1), 'configuration')
                        ->has(ProductPhoto::factory()->count(3), 'photos')
                        ->has(ProductAdditional::factory()->count(3), 'additionals')
                        ->has(ProductReplacement::factory()->count(3), 'replacements')
                            ->count(30), 'products')
                    ->has(Customer::factory()->count(30), 'customers')
                    ->has(Waiter::factory()->count(10), 'waiters')
                        ->count(1), 'stores')
                    ->has(UserSubscription::factory()->count(1), 'subscription')
                    ->create();

        Order::factory()
            ->count(50)
            ->create([
                'user_store_id' => UserStore::first()->id
            ]);
    }

}
