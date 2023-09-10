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
                'paymentTypes',
                'deliveryTypes'
            ])
            ->whereRaw('LOWER(slug) = ?', Str::lower($request->slug))
            ->firstOrFail();

        $store->addresses = [
            [
                'id' => 1,
                'name' => 'João Pessoa'
            ],
            [
                'id' => 2,
                'name' => 'Vieiras'
            ],
            [
                'id' => 3,
                'name' => 'Jaraguá Esquerdo'
            ],
            [
                'id' => 4,
                'name' => 'Barra do Rio Cerro'
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
