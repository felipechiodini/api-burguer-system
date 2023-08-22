<?php

namespace App\Http\Controllers\Panel;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\UserStore;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserStoreController extends Controller
{

    public function index()
    {
        return response()->json(UserStore::all());
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
            'slug' => Helper::generateSlug($request->name)
        ]);

        return response()->json(['message' => 'Loja criada com sucesso!']);
    }

    public function show($uuid, Request $request)
    {
        return response()->json(UserStore::find($uuid));
    }

}
