<?php

namespace App\Observers;

use App\Models\StoreSchedule as ModelsStoreSchedule;

class StoreSchedule
{
    public function creating(ModelsStoreSchedule $storeSchedule): void
    {
        $storeSchedule->user_store_id = app('currentTenant')->id;
    }

}
