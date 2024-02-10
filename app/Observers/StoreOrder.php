<?php

namespace App\Observers;

use App\Models\StoreOrder as ModelsStoreOrder;

class StoreOrder
{

    public function creating(ModelsStoreOrder $storeOrder): void
    {
        $storeOrder->user_store_id = app('currentTenant')->id;
    }

}
