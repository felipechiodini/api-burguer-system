<?php

namespace App\Utils;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Helper {

    public static function makeStoragePath($path)
    {
        if (config('app.env') === 'local') {
            return $path;
        }

        return 'https://d2sbwe6sqww2sr.cloudfront.net/' . $path;
    }

    public static function calculatePercentDiscount($value, $percent)
    {
        return self::calculateDiscount($value, $percent, 'percent');
    }

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
        return preg_replace('/[^0-9]/', '', $value);
    }

    public static function formatCpf($value)
    {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $value);
    }

    public static function formatCellphone($value)
    {
        return preg_replace("/(\d{2})(\d{1})(\d{4})(\d{4})/", "($1) $2 $3-$4", $value);
    }

    public static function formatCurrency($value, $prefix = true)
    {
        if ($prefix === true) return 'R$ ' . number_format($value,2,",",".");
        return number_format($value,2,",",".");
    }

    public static function capitalizeName($name)
    {
        $name = explode(' ', mb_strtolower($name));

        $ignore = [
            'de',
            'da',
            'das',
            'dos',
            'do',
            'e'
        ];

        for ($index = 0; $index < count($name); $index++) {
            if (!in_array($name[$index], $ignore)) $name[$index] = ucfirst($name[$index]);
        }

        return implode(' ', $name);
    }

    public static function coordinatesByCep($cep)
    {
        $address = self::openStreetMapQuery($cep);

        return (object) [
            'latitude' => $address['lat'],
            'longitude' => $address['lon']
        ];
    }

    public static function openStreetMapQuery($cep)
    {
        return Cache::remember("open-street-map-response-{$cep}", now()->addDay(), function() use ($cep) {
            return Http::get("https://nominatim.openstreetmap.org/search?q={$cep}&format=json&addressdetails=1&limit=1")
                ->json()[0];
        });
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

    public static function distanceBetweenTwoCoordinates($a, $b, $c, $d)
    {
        $response = self::googleQuery($a, $b, $c, $d);

        return $response['routes'][0]['legs'][0]['distance']['value'] / 1000;
    }

    public static function googleQuery($a,$b,$c,$d)
    {
        return Cache::remember("$a,$b,$c,$d", now()->addDay(), function () use ($a, $b, $c, $d) {
            return Http::get('https://maps.googleapis.com/maps/api/directions/json', [
                'origin' => "$a,$b",
                'destination' => "$c,$d",
                'key' => 'AIzaSyDjeZ7dRZLdllXMRjLRbw-sC23x58vBam8'
            ])->json();
        });
    }

    public static function generateSlug($name)
    {
        return strtolower(preg_replace('/\s+/', '-', $name));
    }

    public static function resetPasswordToken($length)
    {
        return bin2hex(random_bytes($length));
    }

    public static function formatTime($minutes)
    {
        if ($minutes > 59) {
            return $minutes / 60 . "h";
        }

        return $minutes . "min";
    }

    public static function translateWeekDay($a)
    {
        return $a;
    }
}
