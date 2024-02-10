<?php

namespace App\Observers;

use App\Models\StoreCategory as ModelsStoreCategory;
use Illuminate\Support\Facades\Cache;

class StoreCategory
{
    public function creating(ModelsStoreCategory $storeCategory): void
    {
        $storeCategory->user_store_id = app('currentTenant')->id;
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
