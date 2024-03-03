<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreDeliveryType;
use App\Models\StorePaymentType;
use App\Models\UserStore;
use Illuminate\Http\Request;
use Storage;
use Str;

class StoreController extends Controller
{

    public function all()
    {
        $stores = UserStore::query()
            ->select('name', 'slug')
            ->where('user_id', auth()->user()->id)
            ->get();

        return response()
            ->json(compact('stores'));
    }

    public function get(String $slug)
    {
        $store = [
            'name' => app('currentTenant')->name,
            'slug' => app('currentTenant')->slug,
            'status' => app('currentTenant')->isOpen()
        ];

        return response()
            ->json(compact('store'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'da' => 'dwad'
        ]);

        $store = UserStore::query()
            ->create([
                'user_id' => $request->user()->id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'logo' => Storage::put('logo', $request->file('logo'))
            ]);

        foreach ($request->delivery_types as $type) {
            StoreDeliveryType::query()
                ->create([
                    'store_id' => $store->id,
                    'delivery_type' => $type['id'],
                    'minutes' => $type['minutes']
                ]);
        }

        foreach ($request->payment_types as $type) {
            StorePaymentType::query()
                ->create([
                    'store_id' => $store->id,
                    'payment_type' => $type
                ]);
        }
    }

}
