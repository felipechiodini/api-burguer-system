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
        $store = app('currentTenant');

        $store = [
            'name' => $store->name,
            'slug' => $store->slug,
            'status' => $store->isOpen(),
            'completed_configured' => $store->isCompletedConfigured()
        ];

        return response()
            ->json(compact('store'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $exists = UserStore::query()
            ->where('slug', Str::slug($request->name))
            ->exists();

        if ($exists) throw new \Exception('Não é possivel utilizar este nome');

        $store = UserStore::query()
            ->create([
                'user_id' => $request->user()->id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'logo' => ''
            ]);

        return response()
            ->json(compact('store'));
    }

}
