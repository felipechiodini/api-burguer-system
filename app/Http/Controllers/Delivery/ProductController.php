<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::query()
            ->select('products.id', 'products.name', 'products.description', 'categories.name as category_name')
            ->with([
                'mainPhoto'
            ])
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->where('active', true)
            ->orderBy('categories.order')
            ->get()
            ->each(function(Product $product) {
                $product->price = $product->getCurrentPrice();
            });

        return response()
            ->json(compact('products'));
    }

    public function show(Product $product)
    {
        $product->load([
            'photos',
            'additionals',
            'replacements',
            'followup'
        ]);

        $product->price = $product->getCurrentPrice();

        return response()
            ->json(compact('product'));
    }

}
