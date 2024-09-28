<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $page = StoreOrder::query()
            ->orderBy('id', 'desc')
            ->paginate(10);

        return response()
            ->json(compact('page'));
    }
}
