<?php

namespace App\Http\Controllers\Delivery;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\StoreAddress;
use App\Models\UserStore;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{

    public function calculateValue(Request $request)
    {
        $request->validate([
            'cep' => 'required'
        ]);

        $address = StoreAddress::where('user_store_id', $request->header(UserStore::HEADER_KEY))
            ->first();

        $cordinates = Helper::coordinatesByCep($request->cep);

        $distance = Helper::haversine(
            $address->latitude,
            $address->longitude,
            $cordinates->latitude,
            $cordinates->longitude
        );

        return response()->json($distance);
    }

}
