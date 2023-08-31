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
        $categories = Category::with([
            'products' => function($query) {
                $query->where('active', true);
            },
            'products.photos',
            'products.additionals',
            'products.replacements',
            'products.configuration',
            // 'products.followup',
        ])
        ->get()
        ->each(function($categories) {
            $categories->products->each(function(Product $product) {
                $product->price = $product->getCurrentPrice()->value;
            });
        });

        return response()
            ->json(compact('categories'));
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
