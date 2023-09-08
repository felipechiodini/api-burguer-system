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
                'id' => 'pix',
                'name' => 'Pix'
            ],
            [
                'id' => 'cash',
                'name' => 'Dinheiro'
            ],
            [
                'id' => 'credit-card',
                'name' => 'Cartão Crédito'
            ],
            [
                'id' => 'debit-card',
                'name' => 'Cartão Débito'
            ]
        ];

        $store->delivery_options = [
            [
                'id' => 'shipping',
                'name' => 'Entrega',
                'icon' => 'delivery_dining',
                'time' => '1h'
            ],
            [
                'id' => 'withdraw',
                'name' => 'Retirada',
                'icon' => 'storefront',
                'time' => '30m'
            ]
        ];

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
