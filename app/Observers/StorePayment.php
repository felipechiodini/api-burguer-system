<?php

namespace App\Observers;

use App\Models\StorePayment as ModelsStorePayment;

class StorePayment
{
    public function creating(ModelsStorePayment $storePayment): void
    {
        $storePayment->user_store_id = app('currentTenant')->id;
    }

}
