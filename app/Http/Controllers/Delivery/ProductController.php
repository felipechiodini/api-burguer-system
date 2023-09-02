<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::query()
            ->with([
                'mainPhoto',
                'category'
            ])
            ->where('active', true)
            ->get()
            ->each(function(Product $product) {
                $product->price = $product->getCurrentPrice()->value;
            });

        return response()
            ->json(compact('products'));
    }

    public function show(Product $product)
    {
        $product
            ->load([
                'photos' => function(Builder $query) {
                    $query->select('id', 'src')
                        ->orderBy('order');
                },
                'additionals' => function(Builder $query) {
                    $query->select('name', 'value', 'max');
                },
                'replacements'
            ]);

        return response()
            ->json(compact('product'));
    }

}
