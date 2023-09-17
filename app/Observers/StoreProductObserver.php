<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class StoreProductObserver
{
    public function created()
    {
        Cache::clear();
    }

    public function updated()
    {
        Cache::clear();
    }

    public function deleted()
    {
        Cache::clear();
    }
}
