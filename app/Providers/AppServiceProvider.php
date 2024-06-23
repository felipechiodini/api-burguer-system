<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(\Faker\Generator::class, function () {
            return \Faker\Factory::create('pt_BR');
        });
    }

    public function boot(): void
    {
        \App\Models\StoreSchedule::observe(\App\Observers\StoreSchedule::class);
        \App\Models\StoreNeighborhood::observe(\App\Observers\StoreNeighborhood::class);
        \App\Models\StoreDelivery::observe(\App\Observers\StoreDelivery::class);
        \App\Models\StorePayment::observe(\App\Observers\StorePayment::class);
        \App\Models\StoreAddress::observe(\App\Observers\StoreAddress::class);
        \App\Models\StoreBanner::observe(\App\Observers\StoreBanner::class);
        \App\Models\StoreCustomer::observe(\App\Observers\StoreCustomer::class);
        \App\Models\StoreOrder::observe(\App\Observers\StoreOrder::class);
        \App\Models\StoreCategory::observe(\App\Observers\StoreCategory::class);
        \App\Models\StoreProduct::observe(\App\Observers\StoreProduct::class);
        \App\Models\ProductAdditional::observe(\App\Observers\ProductAdditional::class);
        \App\Models\ProductReplacement::observe(\App\Observers\ProductReplacement::class);
    }
}
