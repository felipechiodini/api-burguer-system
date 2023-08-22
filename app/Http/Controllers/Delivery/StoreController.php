<?php

namespace App\Http\Controllers\Delivery;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\StoreAddress;
use App\Models\UserStore;
use Illuminate\Http\Request;

class StoreController extends Controller
{

    public function get(Request $request)
    {
        $request->validate([
            'slug' => 'required|exists:user_stores,slug'
        ]);

        $store = UserStore::with('configuration', 'banners', 'address', 'categories')
            ->where('slug', $request->slug)
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
