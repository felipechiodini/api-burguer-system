<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\ProductAdditional;
use App\Models\StoreProduct;
use Illuminate\Http\Request;

class ProductAdditionalController extends Controller
{
    public function index(StoreProduct $product, Request $request)
    {
        $page = $product->additionals()
            ->paginate(10);

        return response()
            ->json(compact('page'));
    }

    public function store(StoreProduct $product, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'value' => 'required'
        ]);

        $product->additionals()
            ->create([
                'name' => $request->name,
                'value' => $request->value
            ]);

        return response()
            ->json(['message' => 'Adicional salvo com sucesso!']);
    }

    public function update(StoreProduct $product, ProductAdditional $additional, Request $request)
    {
        $product->additionals()
            ->find($additional->id)
            ->create([
                'name' => $request->input('name'),
                'value' => $request->input('value')
            ]);

        return response()
            ->json(['message' => 'Adicional atualizado com sucesso!']);
    }

    public function destroy(StoreProduct $product, ProductAdditional $additional)
    {
        $product->additionals()
            ->find($additional->id)
            ->delete();

        return response()
            ->json(['message' => 'Adicional excluido com sucesso!']);
    }
}
