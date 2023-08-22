<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Http\Request;

class ProductPriceController extends Controller
{

    public function index(Product $product, Request $request)
    {
        $page = $product->prices()
            ->paginate(10);

        return response()
            ->json(compact('page'));
    }

    public function store(Product $product, Request $request)
    {
        $request->validate([
            'value' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $product->prices()
            ->create([
                'value' => $request->input('value'),
                'start_date' => $request->date('start_date'),
                'end_date' => $request->date('end_date')
            ]);

        return response()
            ->json(['message' => 'Preço cadastrado com sucesso!']);
    }

    public function update(Product $product, ProductPrice $productPrice, Request $request)
    {
        $request->validate([
            'value' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $product->prices()
            ->find($productPrice->id)
            ->update([
                'value' => $request->value,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);

        return response()
            ->json(['message' => 'Preço atualizado com sucesso!']);
    }

    public function destroy(Product $product, ProductPrice $productPrice)
    {
        $product->prices()
            ->find($productPrice->id)
            ->delete();

        return response()
            ->json(['message' => 'Preço deletado com sucesso!']);
    }
}
