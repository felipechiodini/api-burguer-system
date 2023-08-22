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

    public static function captalizeName($name)
    {
        $name = explode(' ', strtolower($name));

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

}
