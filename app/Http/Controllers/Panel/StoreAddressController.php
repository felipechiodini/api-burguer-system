<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreAddress;
use App\Types\Cep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StoreAddressController extends Controller
{
    public function get()
    {
        $address = StoreAddress::query()
            ->select('cep', 'street', 'number', 'neighborhood', 'city', 'state', 'latitude', 'longitude')
            ->first();

        return response()
            ->json(compact('address'));
    }

    public function updateOrCreate(string $slug, Request $request)
    {
        $request->validate([
            'cep' => 'required',
            'street' => 'required',
            'number' => 'required',
            'neighborhood' => 'required',
            'city' => 'required',
            'state' => 'required'
        ]);

        StoreAddress::query()
            ->updateOrCreate([
                'cep' => new Cep($request->cep),
                'street' => $request->street,
                'number' => $request->number,
                'neighborhood' => $request->neighborhood,
                'city' => $request->city,
                'state' => $request->state
            ]);

        Cache::forget("store-$slug");

        return response()
            ->json(['message' => 'Endereço salvo com sucesso!']);
    }
}
