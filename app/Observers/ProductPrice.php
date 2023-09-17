<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class ProductPrice
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
