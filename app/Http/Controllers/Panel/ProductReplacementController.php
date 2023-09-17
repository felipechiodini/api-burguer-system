<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReplacement;
use App\Models\StoreProduct;
use Illuminate\Http\Request;

class ProductReplacementController extends Controller
{
    public function index(StoreProduct $product, Request $request)
    {
        $page = $product->replacements()
            ->paginate(10);

        return response()
            ->json(compact('page'));
    }

    public function store(StoreProduct $product, Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'value' => 'required'
        ]);

        $product->replacements()
            ->create([
                'name' => $request->name,
                'value' => $request->value
            ]);

        return response()
            ->json(['message' => 'Substituição salva com sucesso!']);
    }

    public function update(StoreProduct $product, ProductReplacement $replacement, Request $request)
    {
        $request->validate([
            'name' => 'string',
            'value' => 'integer'
        ]);

        $product->replacements()
            ->find($replacement->id)
            ->update([
                'name' => $request->name,
                'value' => $request->value
            ]);

        return response()
            ->json(['message' => 'Substituição salva com sucesso!']);
    }

    public function destroy(StoreProduct $product, ProductReplacement $replacement)
    {
        $product->replacements()
            ->find($replacement->id)
            ->delete();

        return response()
            ->json(['message' => 'Substituição deletada com sucesso!']);
    }
}
