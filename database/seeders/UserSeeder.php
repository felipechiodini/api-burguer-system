<?php

namespace Database\Seeders;

use App\Models\ChoiceItem;
use App\Models\StoreBanner;
use App\Models\ProductAdditional;
use App\Models\ProductChoice;
use App\Models\ProductReplacement;
use App\Models\StoreAddress;
use App\Models\StoreCategory;
use App\Models\StoreConfiguration;
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
        User::factory()
            ->createOne();

        $store = UserStore::factory()
            ->createOne([
                'user_id' => 1,
                'name' => 'Outro Burguer',
                'slug' => 'outro',
            ]);

        StoreConfiguration::factory()
            ->makeOne(['user_store_id' => $store->id]);

        $store->makeCurrent();

        $categories = ['Entradas', 'Smashs', 'Frango', 'Churrasco', 'Kids', 'Porções', 'Combos', 'Bebidas', 'Milk', 'Cervejas'];
        foreach ($categories as $key => $value) {
            StoreCategory::create(['name' => $value, 'order' => $key]);
        }

        StoreAddress::factory()->count(1)->create();
        StoreCustomer::factory()->count(30)->create();
        StoreProduct::factory()
            ->has(ProductAdditional::factory()->count(3), 'additionals')
            ->has(ProductReplacement::factory()->count(3), 'replacements')
            ->count(30)
            ->create()
            ->each(function($model) {
                $choice = ProductChoice::factory()
                    ->create(['product_id' => $model->id]);

                ChoiceItem::query()
                    ->create([
                        'choice_id' => $choice->id,
                        'name' => 'kkkkkkkkkkkkk',
                        'value' => 20,
                    ]);
            });

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
