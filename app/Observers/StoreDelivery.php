<?php

namespace App\Observers;

use App\Models\StoreDelivery as ModelsStoreDelivery;

class StoreDelivery
{
    public function creating(ModelsStoreDelivery $storeDelivery): void
    {
        $storeDelivery->store_id = app('currentTenant')->id;
    }

}
