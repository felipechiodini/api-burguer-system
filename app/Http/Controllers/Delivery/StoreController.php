<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\StoreAddress;
use App\Models\UserStore;
use App\Utils\Helper as UtilsHelper;
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
                // 'paymentTypes',
                // 'deliveryOptions'
            ])
            ->whereRaw('LOWER(slug) = ?', Str::lower($request->slug))
            ->firstOrFail();

        $store->payments = [
            [
                'id' => 1,
                'name' => 'Pix'
            ],
            [
                'id' => 2,
                'name' => 'Dinheiro'
            ],
            [
                'id' => 3,
                'name' => 'Cartão Crédito'
            ],
            [
                'id' => 4,
                'name' => 'Cartão Débito'
            ]
        ];

        return response()
            ->json(compact('store'));
    }

    public function distance(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $address = StoreAddress::first();

        $distance = UtilsHelper::distanceBetweenTwoCoordinates($request->latitude, $request->longitude, $address->latitude, $address->longitude);

        return response()->json([
            'distance' => number_format($distance, 1)
        ]);
    }

}
