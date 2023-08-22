<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\UserStore;
use App\Models\Waiter;
use Illuminate\Http\Request;

class WaiterController extends Controller
{

    public function index()
    {
        $waiters = Waiter::paginate(50);

        return response()->json($waiters);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $waiter = Waiter::create([
            'store_id'=> $request->header(UserStore::HEADER_KEY),
            'name' => $request->name
        ]);

        return response()->json(['message' => 'Garçom registrado com sucesso', 'waiter' => $waiter]);
    }

    public function show(Waiter $waiter)
    {
        return response()->json($waiter);
    }

    public function destroy(Waiter $waiter)
    {
        $waiter->delete();
        return response()->json(['message' => 'Garçom inativado']);
    }

}
