<?php

namespace App\Observers;

use App\Models\StoreBanner as ModelsStoreBanner;

class StoreBanner
{
    public function creating(ModelsStoreBanner $storeBanner): void
    {
        $storeBanner->store_id = app('currentTenant')->id;
    }

}
