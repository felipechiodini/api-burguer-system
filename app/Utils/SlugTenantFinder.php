<?php

namespace App\Utils;

use Spatie\Multitenancy\Models\Concerns\UsesTenantModel;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\TenantFinder\TenantFinder;
use Illuminate\Http\Request;

class SlugTenantFinder extends TenantFinder {

    use UsesTenantModel;

    public function findForRequest(Request $request): ?Tenant
    {
        $slug = explode('.', $request->getHost())[0];

        return $this->getTenantModel()::where('slug', $slug)->first();
    }
}
