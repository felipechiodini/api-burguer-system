<?php

namespace App\Observers;

use App\Models\StorePayment as ModelsStorePayment;

class StorePayment
{
    public function creating(ModelsStorePayment $storePayment): void
    {
        $storePayment->store_id = app('currentTenant')->id;
    }

}
