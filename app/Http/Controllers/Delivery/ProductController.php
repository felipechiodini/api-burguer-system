<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\ProductPhoto;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{

    public function get(Request $request)
    {
        $products = Cache::remember($request->fullUrl(), now()->addDay(), function () {
            return StoreProduct::query()
                ->select(['store_products.id', 'store_products.name', 'store_products.description', 'store_products.store_category_id', 'store_categories.name as category_name'])
                ->where('active', true)
                ->join('store_categories', function($join) {
                    $join->on('store_categories.id', 'store_products.store_category_id');
                })
                ->orderBy('store_categories.order')
                ->get()
                ->map(function(StoreProduct $product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'store_category_id' => $product->store_category_id,
                        'price' => $product->getCurrentPrice(),
                        'photo' => ProductPhoto::query()
                            ->orderBy('order')
                            ->first()
                    ];
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
                'configuration',
                'followup'
            ]);

            $product->price = $product->getCurrentPrice();

            return $product;
        });

        return response()
            ->json(compact('product'));
    }

}
