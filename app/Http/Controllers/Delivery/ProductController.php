<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::query()
            ->with([
                'photos',
                'additionals',
                'replacements',
                'configuration',
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

    public function show($product, Request $request)
    {
        $product = Product::query()
            ->with([
                'photos' => function(Builder $query) {
                    $query->select('id', 'src')
                        ->orderBy('order');
                },
                'additionals' => function(Builder $query) {
                    $query->select('name', 'value', 'max');
                },
                'replacements'
            ])
            ->where('id', $product)
            ->first();

        return response()->json($product);
    }

}
