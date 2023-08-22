<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReplacement;
use Illuminate\Http\Request;

class ProductReplacementController extends Controller
{
    public function index(Product $product, Request $request)
    {
        $page = $product->replacements()
            ->paginate(10);

        return response()
            ->json(compact('page'));
    }

    public function store(Product $product, Request $request)
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

    public function update(Product $product, ProductReplacement $productReplacement, Request $request)
    {
        $request->validate([
            'name' => 'string',
            'value' => 'integer'
        ]);

        $product->replacements()
            ->find($productReplacement->id)
            ->update([
                'name' => $request->name,
                'value' => $request->value
            ]);

        return response()
            ->json(['message' => 'Substituição salva com sucesso!']);
    }

    public function destroy(Product $product, ProductReplacement $productReplacement)
    {
        $product->replacements()
            ->find($productReplacement->id)
            ->delete();

        return response()
            ->json(['message' => 'Substituição deletada com sucesso!']);
    }
}
