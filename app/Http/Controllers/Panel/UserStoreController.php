<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\UserStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class UserStoreController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $stores = $user->stores()->get();

        return response()
            ->json(compact('stores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        UserStore::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return response()->json(['message' => 'Loja criada com sucesso!']);
    }

    public function setStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|boolean'
        ]);

        app('currentTenant')->configuration()
            ->update([
                'store_open' => $request->status
            ]);

        Cache::flush();

        return response()
            ->json(['message' => 'Sucesso!']);
    }
}
