<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreNeighborhood;
use Illuminate\Http\Request;

class NeighborhoodController extends Controller
{

    public function index(Request $request)
    {
        $page = StoreNeighborhood::query()
            ->paginate(10);

        return response()
            ->json(compact('page'));
    }

    public function store(Request $request)
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

        return response()
            ->json(['message' => 'Bairro salvo com sucesso!']);
    }

}
