<?php

namespace App\Providers;

use App\Models\StoreProduct;
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
        StoreProduct::observe(\App\Observers\StoreProductObserver::class);
        StoreProduct::observe(\App\Observers\ProductPhoto::class);
        StoreProduct::observe(\App\Observers\ProductPrice::class);
        StoreProduct::observe(\App\Observers\ProductAdditional::class);
        StoreProduct::observe(\App\Observers\ProductReplacement::class);
    }
}
