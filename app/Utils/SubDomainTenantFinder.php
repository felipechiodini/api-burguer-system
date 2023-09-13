<?php

namespace App\Utils;

use Spatie\Multitenancy\Models\Concerns\UsesTenantModel;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\TenantFinder\TenantFinder;
use Illuminate\Http\Request;

class SubDomainTenantFinder extends TenantFinder
{
    use UsesTenantModel;

    public function findForRequest(Request $request): ?Tenant
    {
        $slug = explode('/', $request->getPathInfo())[2] ?? null;

        return $this->getTenantModel()::where('slug', $slug)->first();
    }
}
