<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\UserStore;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $request->validate([
            'term' => 'string|nullable'
        ]);

        $page = Product::query()
            ->when($request->query('term'), function($query) use (&$request) {
                $query->where('name', $request->term);
            })
            ->paginate(20);

        return response()->json(compact('page'));
    }

    public function store(Request $request)
    {
        $product = Product::create([
            'user_store_id' => UserStore::query()->first()->id,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description
        ]);

        return response()
            ->json([
                'message' => 'Produto criado com sucesso!',
                'product' => $product
            ]);
    }

    public function show($product)
    {

        dd($product);

        return response()
            ->json(compact('product'));
    }

    public function update($product, Request $request)
    {
        $product = Product::find($product)
            ->update($request->all());

        return response()->json([
            'message' => 'Produto atualizado com sucesso'
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Produto deletado']);
    }

}
