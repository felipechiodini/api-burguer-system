<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Utils\Helper;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{

    public function calculateShipping(Request $request)
    {
        $request->validate([
            'cep' => 'required'
        ]);

        $cordinates = Helper::coordinatesByCep('89253390');

        $distance = Helper::distanceBetweenTwoCoordinates(
            '-26.5050371',
            '-49.097304',
            $cordinates->latitude,
            $cordinates->longitude
        );

        return response()->json($distance);
    }

}
