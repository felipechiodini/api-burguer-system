<?php

namespace App\Http\Controllers\Delivery;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Models\ProductPhoto;
use App\Models\StoreProduct;
use App\Models\UserStore;
use Illuminate\Http\Request;
use App\Utils\Helper;

class StoreController extends Controller
{

    public function get(String $slug, Request $request)
    {
        $store = Cache::remember($request->fullUrl(), now()->addDay(), function () use ($slug) {
            $store = UserStore::query()
                ->where('slug', $slug)
                ->first()
                ->load([
                    'categories',
                    'configuration',
                    'banners',
                    'address',
                    'paymentOptions',
                    'deliveryOptions',
                    'shippingOptions'
                ]);

            $store->open = $store->isOpen();

            $store =  $store->toArray();

            foreach ($store['delivery_options'] as $key => $option) {
                $new = [
                    'id' => $option['id'],
                    'name' => $option['name'],
                    'icon' => $option['icon'],
                    'time' => Helper::formatTime($option['pivot']['minutes'])
                ];

                $store['delivery_options'][$key] = $new;
            }

            $store['products'] = StoreProduct::query()
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

            return $store;
        });

        return response()
            ->json(compact('store'));
    }

    public function distance(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $address = app('currentTenant')
            ->address()
            ->first();

        $distance = Helper::distanceBetweenTwoCoordinates($request->latitude, $request->longitude, $address->latitude, $address->longitude);

        return response()->json([
            'distance' => number_format($distance, 1)
        ]);
    }
}
