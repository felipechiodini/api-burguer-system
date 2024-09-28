<?php

namespace App\Observers;

use App\Models\StoreNeighborhood as ModelsStoreNeighborhood;

class StoreNeighborhood
{
    public function creating(ModelsStoreNeighborhood $storeNeighborhood): void
    {
        $storeNeighborhood->store_id = app('currentTenant')->id;
    }

}
