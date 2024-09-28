<?php

namespace App\Observers;

use App\Models\StoreCustomer as ModelsStoreCustomer;

class StoreCustomer
{
    public function creating(ModelsStoreCustomer $storeCustomer): void
    {
        $storeCustomer->store_id = app('currentTenant')->id;
    }

}
