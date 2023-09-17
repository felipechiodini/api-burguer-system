<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\Helper;

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

        app('currentTenant')
            ->address()
            ->updateOrCreate([
                'cep' => Helper::clearAllIsNotNumber($request->cep),
                'street' => $request->street,
                'district' => $request->district,
                'number' => $request->number,
                'city' => $request->city,
                'state' => $request->state,
            ]);

        return response()
            ->json(['message' => 'Endereço salvo com sucesso!']);
    }

}
