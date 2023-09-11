<?php

namespace App\Http\Controllers\Delivery;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\Helper;

class StoreController extends Controller
{

    public function get(Request $request)
    {
        $store = Cache::remember($request->fullUrl(), now()->addDay(), function () {
            $store = app('currentTenant')
                ->load([
                    'configuration',
                    'banners',
                    'address',
                    'categories',
                    'paymentOptions',
                    'deliveryOptions',
                    'shippingOptions'
                ])
                ->toArray();

            foreach ($store['delivery_options'] as $key => $option) {
                $new = [
                    'id' => $option['id'],
                    'name' => $option['name'],
                    'icon' => $option['icon'],
                    'time' => Helper::formatTime($option['pivot']['minutes'])
                ];

                $store['delivery_options'][$key] = $new;
            }

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
