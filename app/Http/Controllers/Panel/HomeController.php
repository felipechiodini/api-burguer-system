<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreOrder;

class HomeController extends Controller
{

    public function get()
    {
        $value = StoreOrder::query()
            ->where('created_at', now()->startOfDay()->toDateTimeString())
            ->where('created_at', now()->endOfDay()->toDateTimeString())
            ->get()
            ->sum('origin');

        $home = [
            'link' => 'https://bona.burguersystem.online',
            'open_orders' => $value
        ];

        return response()
            ->json(compact('home'));
    }

}
