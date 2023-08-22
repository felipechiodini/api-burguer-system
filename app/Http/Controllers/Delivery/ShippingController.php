<?php

namespace App\Http\Controllers\Delivery;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\StoreAddress;
use App\Models\StoreConfiguration;
use Illuminate\Http\Request;

class ShippingController extends Controller
{

    public function value(Request $request)
    {
        $request->validate([
            'cep' => 'required'
        ]);

        $coordinates = Helper::coordinatesByCep($request->cep);

        $address = StoreAddress::first();

        $distance = Helper::distanceBetweenTwoCoordinates("$coordinates->latitude,$coordinates->longitude", "$address->latitude,$address->longitude");

        $configuration = StoreConfiguration::first();

        $value = $distance * $configuration->delivery_price_per_km;

        return response()->json(['value' => round($value)]);
    }

}
