<?php

namespace App\Http\Controllers\Panel;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\StoreAddress;
use App\Models\UserStore;
use Illuminate\Http\Request;

class StoreAddressController extends Controller
{
    public function updateOrCreate(Request $request)
    {
        $request->validate([
            'cep' => 'required',
            'street' => 'required',
            'number' => 'required',
            'district' => 'required',
            'city' => 'required',
            'state' => 'required'
        ]);

        $coordinates = Helper::coordinatesByCep(Helper::clearAllIsNotNumber($request->cep));

        StoreAddress::updateOrCreate([
            'user_store_id' => $request->header(UserStore::HEADER_KEY)
        ], [
            'cep' => Helper::clearAllIsNotNumber($request->cep),
            'street' => $request->street,
            'district' => $request->district,
            'number' => $request->number,
            'city' => $request->city,
            'state' => $request->state,
            'latitude' => $coordinates->latitude,
            'longitude' => $coordinates->longitude
        ]);

        return response()->json(['message' => 'Endereço salvo com sucesso!']);
    }

}
