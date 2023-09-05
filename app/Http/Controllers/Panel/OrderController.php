<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $page = Order::query()
            ->with([
                'customer',
                'delivery.address'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()
            ->json(compact('page'));
    }


}
