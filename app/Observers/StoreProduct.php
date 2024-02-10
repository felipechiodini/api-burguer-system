<?php

namespace App\Observers;

use App\Models\StoreProduct as ModelsStoreProduct;
use Illuminate\Support\Facades\Cache;

class StoreProduct
{

    public function creating(ModelsStoreProduct $storeProduct): void
    {
        $storeProduct->user_store_id = app('currentTenant')->id;
    }

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
