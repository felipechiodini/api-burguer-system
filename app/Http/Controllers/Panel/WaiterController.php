<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreWaiter;
use Illuminate\Http\Request;

class WaiterController extends Controller
{

    public function index()
    {
        $page = StoreWaiter::query()
            ->paginate(20);

        return response()
            ->json(compact('page'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $waiter = StoreWaiter::create([
            'user_store_id'=> app('currentTenant')->id,
            'name' => $request->name
        ]);

        return response()
            ->json([
                'message' => 'Garçom registrado com sucesso',
                'waiter' => $waiter
            ]);
    }

    public function show(StoreWaiter $waiter)
    {
        return response()
            ->json(compact('waiter'));
    }

    public function destroy(StoreWaiter $waiter)
    {
        $waiter->delete();

        return response()
            ->json(['message' => 'Garçom inativado']);
    }
}
