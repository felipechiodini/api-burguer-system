<?php

namespace App\Http\Controllers\Delivery;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\StoreAddress;
use App\Models\UserStore;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreController extends Controller
{

    public function get(Request $request)
    {
        $request->validate([
            'slug' => 'required|string'
        ]);

        $store = UserStore::query()
            ->with([
                'configuration',
                'banners',
                'address',
                'categories',
                'paymentTypes'
            ])
            ->whereRaw('LOWER(slug) = ?', Str::lower($request->slug))
            ->firstOrFail();

        return response()->json($store);
    }

    public function distance(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $address = StoreAddress::first();

        $distance = Helper::distanceBetweenTwoCoordinates("$request->latitude,$request->longitude", "$address->latitude,$address->longitude");

        return response()->json([
            'distance' => number_format($distance, 1)
        ]);
    }

}
