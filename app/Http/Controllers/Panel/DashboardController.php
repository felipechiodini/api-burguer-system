<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreOrder;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $ordernumber = StoreOrder::query()
            ->where('created_at', now()->startOfDay()->toDateTimeString())
            ->where('created_at', now()->endOfDay()->toDateTimeString())
            ->count();

        $dashboard = [
            'order_number' => $ordernumber
        ];

        return response()
            ->json(compact('dashboard'));
    }
}
