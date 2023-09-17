<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreCustomer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $page = StoreCustomer::query()
            ->paginate(10);

        return response()
            ->json(compact('page'));
    }
}
