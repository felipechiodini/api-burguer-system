<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Utils\Helper;
use Illuminate\Http\Request;

class StoreController extends Controller
{

    public function get(Request $request)
    {
        $store = app('currentTenant')
            ->load([
                'configuration',
                'banners',
                'address',
                'categories',
                'payment',
                'delivery'
            ]);

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

        $address = app('currentTenant')
            ->address()
            ->first();

        $distance = Helper::distanceBetweenTwoCoordinates($request->latitude, $request->longitude, $address->latitude, $address->longitude);

        return response()->json([
            'distance' => number_format($distance, 1)
        ]);
    }
}
