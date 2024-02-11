<?php

namespace App\Maps;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Maps {

    public static function getDistance(String $origin, String $destiny)
    {
        return Cache::remember("{$origin}-{$destiny}", now()->addDay(), function() use ($origin, $destiny) {
            $request = Http::baseUrl('https://maps.googleapis.com')
                ->get('maps/api/distancematrix/json', [
                    'units' => 'metric',
                    'origins' => $origin,
                    'destinations' => $destiny,
                    'key' => self::getApiKey(),
                ]);

            if ($request->failed()) {
                return null;
            }

            return (new MatrixResponse($request->object()))->getDistance();
        });
    }

    private static function getApiKey(): String
    {
        return config('maps.matrix.api_key');
    }

}
