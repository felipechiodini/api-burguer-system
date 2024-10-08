<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\StoreCategory;
use Illuminate\Http\Request;

class CardController extends Controller
{

    public function index(Request $request)
    {
        $page = Card::query()
            ->orderBy('id', 'desc')
            ->paginate(10);

        return response()
            ->json(compact('page'));
    }

    public function show(String $tenant, StoreCategory $category)
    {
        return response()
            ->json(compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        StoreCategory::create([
            'store_id' => app('currentTenant')->id,
            'name' => $request->name,
            'order' => StoreCategory::query()->max('order')
        ]);

        return response()
            ->json(['message' => 'Categoria criada com sucesso!']);
    }

    public function update(String $tenant, StoreCategory $category, Request $request)
    {
        $request->validate([
            'name' => 'string'
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return response()
            ->json(['message' => 'Categoria atualizada com sucesso!']);
    }

    public function destroy(String $tenant, StoreCategory $category)
    {
        $category->delete();

        return response()
            ->json(['message' => 'Categoria excluída com sucesso!',]);
    }

}
