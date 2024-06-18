<?php

namespace App\Http\Controllers\Delivery;

use App\Enums\Order\Delivery;
use App\Enums\Order\Payment;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Maps\Maps;
use App\Models\ProductPhoto;
use App\Models\StoreAddress;
use App\Models\StoreBanner;
use App\Models\StoreCategory;
use App\Models\StoreConfiguration;
use App\Models\StoreDelivery;
use App\Models\StoreNeighborhood;
use App\Models\StorePayment;
use App\Models\StoreProduct;
use App\Models\StoreTable;
use App\Models\UserStore;
use Illuminate\Http\Request;
use App\Utils\Helper;

class StoreController extends Controller
{

    public function get(String $slug, Request $request)
    {
        if ($request->has('table')) {
            StoreTable::query()
                ->where('id', $request->input('table'))
                ->exists();
        }

        $store = Cache::remember($request->fullUrl(), now()->addDay(), function () use ($slug) {
            $store = UserStore::query()
                ->where('slug', $slug)
                ->first();

            $configuration = StoreConfiguration::query()
                ->select('warning', 'minimum_order_value')
                ->first();

            $banners = StoreBanner::query()
                ->select('src')
                ->orderBy('order')
                ->get()
                ->map(function($banner) {
                    return [
                        'src' => $banner->src
                    ];
                });

            $categories = StoreCategory::query()
                ->select('name')
                ->orderBy('order')
                ->get();

            $address = StoreAddress::query()
                ->select('cep', 'street', 'number', 'neighborhood', 'city', 'state', 'latitude', 'longitude')
                ->first();

            $products = StoreProduct::query()
                ->select(
                    'store_products.id',
                    'store_products.name',
                    'store_products.description',
                    'store_products.price_from',
                    'store_products.price_to',
                    'store_products.store_category_id',
                    'store_categories.name as category_name',
                )
                ->where('active', true)
                ->join('store_categories', fn ($join) => $join->on('store_categories.id', 'store_products.store_category_id'))
                ->orderBy('store_categories.order')
                ->get()
                ->map(function(StoreProduct $product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'category_name' => $product->category_name,
                        'price' => [
                            'from' => $product->price_from,
                            'to' => $product->price_to
                        ],
                        'photo' => ProductPhoto::query()
                            ->orderBy('order')
                            ->first()
                    ];
                });

            $deliveryOptions = StoreDelivery::query()
                ->select('type', 'minutes')
                ->get()
                ->map(function($model) {
                    return [
                        'type' => $model->type,
                        'name' => Delivery::getDescription($model->type),
                        'minutes' => $model->minutes
                    ];
                });

            $paymentOptions = StorePayment::query()
                ->select('type')
                ->get()
                ->map(function($model) {
                    return [
                        'type' => $model->type,
                        'name' => Payment::getDescription($model->type)
                    ];
                });

            $neighborhoods = StoreNeighborhood::query()
                ->select('id', 'name', 'price')
                ->where('active', true)
                ->get();

            return [
                'name' => $store->name,
                'logo' => Helper::makeStoragePath($store->logo),
                'open' => $store->isOpen(),
                'configuration' => $configuration,
                'banners' => $banners,
                'categories' => $categories,
                'address' => $address,
                'products' => $products,
                'neighborhood_options' => $neighborhoods,
                'delivery_options' => $deliveryOptions,
                'payment_options' => $paymentOptions,
            ];
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

        $address = StoreAddress::query()
            ->first('latitude', 'longitude');

        $distance = Maps::getDistance(
            $request->latitude,
            $request->longitude,
            // $address->latitude,
            // $address->longitude
        );

        return response()
            ->json(compact('distance'));
    }

}
