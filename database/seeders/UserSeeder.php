<?php

namespace Database\Seeders;

use App\Models\DeliveryAddress;
use App\Models\OrderDelivery;
use App\Models\OrderPayment;
use App\Models\OrderProduct;
use App\Models\StoreBanner;
use App\Models\StoreOrder;
use App\Models\ProductAdditional;
use App\Models\ProductConfiguration;
use App\Models\ProductPhoto;
use App\Models\ProductPrice;
use App\Models\ProductReplacement;
use App\Models\StoreAddress;
use App\Models\StoreCategory;
use App\Models\StoreCustomer;
use App\Models\StoreDelivery;
use App\Models\StoreNeighborhood;
use App\Models\StorePayment;
use App\Models\StoreProduct;
use App\Models\StoreSchedule;
use App\Models\User;
use App\Models\UserStore;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run()
    {
        User::factory()->count(1)->create();

        $f = UserStore::query()
                ->create([
                    'user_id' => 1,
                    'name' => 'Outro Burguer',
                    'slug' => 'outro',
                    'logo' => 'logo.png'
                ]);

        $f->makeCurrent();

        // UserStore::factory()
        //     ->has(StoreBanner::factory()->count(3), 'banners')
        //     ->has(StoreCategory::factory()->count(10), 'categories')
        //     ->has(StoreCustomer::factory()->count(30), 'customers')
        //     ->has(StoreProduct::factory()
        //             ->has(ProductPrice::factory()->count(1), 'prices')
        //             ->has(ProductConfiguration::factory()->count(1), 'configuration')
        //             ->has(ProductPhoto::factory()->count(3), 'photos')
        //             ->has(ProductAdditional::factory()->count(3), 'additionals')
        //             ->has(ProductReplacement::factory()->count(3), 'replacements')
        //             ->count(30), 'products')
        //     ->count(2)
        //     ->state(new Sequence(
        //         ['name' => 'Plankton Burguer', 'slug' => 'plankton'],
        //         ['name' => 'Bona Burguer', 'slug' => 'bona']
        //     ))
        //     ->create();

        // StorePaymentType::query()
        //     ->create([
        //         'user_store_id' => 1,
        //         'payment_type_id' => 'pix'
        //     ]);

        // StorePaymentType::query()
        //     ->create([
        //         'user_store_id' => 2,
        //         'payment_type_id' => 'pix'
        //     ]);

        // StoreDeliveryType::query()->create(['user_store_id' => 2,'delivery_type_id' => 'delivery','minutes' => 60]);
        // StoreDeliveryType::query()->create(['user_store_id' => 2,'delivery_type_id' => 'withdraw','minutes' => 30]);

        // StoreShippingOptions::query()->create(['user_store_id' => 2, 'name' => 'João Pessoa', 'value' => 0]);
        // StoreShippingOptions::query()->create(['user_store_id' => 2, 'name' => 'Vieiras', 'value' => 3]);

        $categories = ['Entradas', 'Smashs', 'Frango', 'Churrasco', 'Kids', 'Porções', 'Combos', 'Bebidas', 'Milk', 'Cervejas'];
        foreach ($categories as $key => $value) {
            StoreCategory::create(['name' => $value, 'order' => $key]);
        }

        StoreAddress::factory()->count(1)->create();
        StoreBanner::factory()->count(3)->create();
        StoreCustomer::factory()->count(30)->create();
        StoreProduct::factory()
            ->has(ProductPrice::factory()->count(1), 'prices')
            ->has(ProductConfiguration::factory()->count(1), 'configuration')
            ->has(ProductPhoto::factory()->count(3), 'photos')
            ->has(ProductAdditional::factory()->count(3), 'additionals')
            ->has(ProductReplacement::factory()->count(3), 'replacements')
            ->count(30)
            ->create();

        StoreSchedule::create(['week_day' => 1, 'start' => '13:00:00', 'end' => '17:00:00']);
        StoreSchedule::create(['week_day' => 2, 'start' => '13:00:00', 'end' => '17:00:00']);
        StoreSchedule::create(['week_day' => 3, 'start' => '13:00:00', 'end' => '17:00:00']);
        StoreSchedule::create(['week_day' => 4, 'start' => '13:00:00', 'end' => '17:00:00']);
        StoreSchedule::create(['week_day' => 5, 'start' => '13:00:00', 'end' => '17:00:00']);
        StoreSchedule::create(['week_day' => 6, 'start' => '13:00:00', 'end' => '17:00:00']);
        StoreSchedule::create(['week_day' => 7, 'start' => '13:00:00', 'end' => '17:00:00']);
        StoreNeighborhood::create(['active' => true, 'name' => 'João Pessoa', 'price' => 17]);
        StoreNeighborhood::create(['active' => true, 'name' => 'Vieiras', 'price' => 9]);
        StoreDelivery::create(['active' => true, 'type' => 1, 'minutes' => 50]);
        StoreDelivery::create(['active' => true, 'type' => 2, 'minutes' => 20]);
        StorePayment::create(['active' => true, 'type' => 4]);

        // StoreOrder::factory()
        //     ->count(50)
        //     ->has(OrderProduct::factory(1), 'products')
        //     ->has(OrderDelivery::factory(1), 'delivery')
        //     ->has(OrderPayment::factory(1), 'payment')
        //     ->create();
    }

}
