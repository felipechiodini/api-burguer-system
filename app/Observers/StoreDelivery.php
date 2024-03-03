<?php

namespace App\Observers;

use App\Models\StoreDelivery as ModelsStoreDelivery;

class StoreDelivery
{
    public function creating(ModelsStoreDelivery $storeDelivery): void
    {
        $storeDelivery->user_store_id = app('currentTenant')->id;
    }

}
