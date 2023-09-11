<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\ProductPhoto;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = Cache::remember($request->fullUrl(), now()->addDay(), function () {
            return StoreProduct::query()
                ->where('active', true)
                ->join('store_categories', function($join) {
                    $join->on('store_categories.id', 'store_products.store_category_id');
                })
                ->orderBy('store_categories.order')
                ->get(['store_products.id', 'store_products.name', 'store_products.description', 'store_products.store_category_id', 'store_categories.name as category_name'])
                ->each(function(StoreProduct $product) {
                    $product->price = $product->getCurrentPrice();
                    $product->photo = ProductPhoto::query()
                        ->orderBy('order')
                        ->first();
                });
        });

        return response()
            ->json(compact('products'));
    }

    public function show(String $tenant, StoreProduct $product, Request $request)
    {
        $product = Cache::remember($request->fullUrl(), now()->addDay(), function () use ($product) {
            $product->load([
                'photos',
                'additionals',
                'replacements',
                'followup'
            ]);

            $product->price = $product->getCurrentPrice();

            return $product;
        });

        return response()
            ->json(compact('product'));
    }
}
