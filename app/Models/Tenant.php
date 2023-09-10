<?php

namespace App\Models;

use Spatie\Multitenancy\Models\Tenant as ModelsTenant;

class Tenant extends ModelsTenant
{
    public function stores()
    {
        return $this->hasMany(TenantStore::class);
    }
}
