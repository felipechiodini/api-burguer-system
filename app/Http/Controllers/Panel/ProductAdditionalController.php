<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAdditional;
use Illuminate\Http\Request;

class ProductAdditionalController extends Controller
{
    public function index(Product $product, Request $request)
    {
        $page = $product->additionals()
            ->paginate(10);

        return response()
            ->json(compact('page'));
    }

    public function store(Product $product, Request $request)
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

    public function update(Product $product, ProductAdditional $productAdditional, Request $request)
    {
        $product->additionals()
            ->find($productAdditional->id)
            ->create([
                'name' => $request->input('name'),
                'value' => $request->input('value')
            ]);

        return response()
            ->json(['message' => 'Adicional atualizado com sucesso!']);
    }

    public function destroy(Product $product, ProductAdditional $productAdditional)
    {
        $product->additionals()
            ->find($productAdditional->id)
            ->delete();

        return response()
            ->json(['message' => 'Adicional excluido com sucesso!']);
    }
}
