<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\StoreProduct;

class ProductController extends Controller
{

    public function index()
    {
        $products = StoreProduct::query()
            ->select('store_products.id', 'store_products.name', 'store_products.description')
            ->with([
                'mainPhoto'
            ])
            ->where('active', true)
            ->get()
            ->each(function(StoreProduct $product) {
                $product->price = $product->getCurrentPrice();
            });

        return response()
            ->json(compact('products'));
    }

    public function show(StoreProduct $product)
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
