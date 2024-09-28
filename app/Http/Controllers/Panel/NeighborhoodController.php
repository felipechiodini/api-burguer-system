<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreNeighborhood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class NeighborhoodController extends Controller
{
    public function index(Request $request)
    {
        $page = StoreNeighborhood::query()
            ->paginate(10);

        return response()
            ->json(compact('page'));
    }

    public function store(string $slug, Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required'
        ]);

        StoreNeighborhood::query()
            ->create([
                'active' => true,
                'name' => $request->name,
                'price' => $request->price
            ]);

        Cache::forget("store-$slug");

        return response()
            ->json(['message' => 'Bairro salvo com sucesso!']);
    }
}
