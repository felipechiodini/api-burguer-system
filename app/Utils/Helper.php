<?php

namespace App\Utils;

use Exception;
use Illuminate\Support\Facades\Http;

class Helper {

    public static function calculateDiscount($value, $discountValue, $type)
    {
        switch ($type) {
            case 'percent':
                return $value * ($discountValue / 100);
                break;
            case 'unit':
                $finalValue = $value - $discountValue;
                return $finalValue > 0 ?? 0;
                break;
            default:
                throw new Exception('Discount type not identified');
        }
    }

    public static function clearAllIsNotNumber($value)
    {
        return $value;
    }

    public static function coordinatesByCep($cep)
    {
        $address = Http::get("https://nominatim.openstreetmap.org/search?q={$cep}&format=json&addressdetails=1&limit=1")
            ->json()[0];

        return (object) [
            'latitude' => $address['lat'],
            'longitude' => $address['lon']
        ];
    }

    public static function haversine($lat1, $lon1, $lat2, $lon2, $unit = 'K')
    {
        $R = 6371; // Raio da Terra em km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $d = $R * $c;
        if ($unit == "M") {
            return $d * 1000;
        } else {
            return $d;
        }
    }

    public static function distanceBetweenTwoCoordinates($origin, $destination)
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/directions/json', [
            'origin' => $origin,
            'destination' => $destination,
            'key' => 'AIzaSyDjeZ7dRZLdllXMRjLRbw-sC23x58vBam8'
        ])->json();

        return $response['routes'][0]['legs'][0]['distance']['value'] / 1000;
    }

    public static function generateSlug($name)
    {
        return strtolower(preg_replace('/\s+/', '-', $name));
    }

}
