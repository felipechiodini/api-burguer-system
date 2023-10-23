<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('web')
                ->domain(config('app.web'))
                ->namespace('App\Http\Controllers\Company')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->domain(config('app.api'))
                ->group(function() {
                    Route::namespace('App\Http\Controllers')
                        ->group(base_path('routes/api.php'));

                    Route::prefix('panel')
                        ->namespace('App\Http\Controllers\Panel')
                        ->group(base_path('routes/panel.php'));

                    Route::middleware('tenant')
                        ->prefix('delivery/{tenant}')
                        ->namespace('App\Http\Controllers\Delivery')
                        ->group(base_path('routes/delivery.php'));
                });
        });
    }
}
