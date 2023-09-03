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
            // 'followup'
        ]);

        $product->price = $product->getCurrentPrice();

        return response()
            ->json(compact('product'));
    }

}
