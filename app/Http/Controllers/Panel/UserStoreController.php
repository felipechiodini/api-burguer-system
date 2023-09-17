<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\UserStore;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserStoreController extends Controller
{

    public function all(Request $request)
    {
        $stores = UserStore::query()
            ->where('user_id', $request->user()->id)
            ->get();

        return response()
            ->json(compact('stores'));
    }

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
            'name' => 'required|string',
            'slug' => 'required|string'
        ]);

        UserStore::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'slug' => Str::lower($request->slug)
        ]);

        return response()
            ->json(['message' => 'Loja criada com sucesso!']);
    }

    public function setStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|boolean'
        ]);

        UserStore::query()
            ->find(app('currentTenant')->id)
            ->configuration()
            ->update([
                'store_open' => $request->status
            ]);

        return response()
            ->json(['message' => 'Sucesso!']);
    }
}
