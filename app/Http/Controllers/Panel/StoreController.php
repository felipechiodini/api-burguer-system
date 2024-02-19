<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\UserStore;
use Illuminate\Http\Request;

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
            'is_open' => app('currentTenant')->isOpen()
        ];

        return response()
            ->json(compact('store'));
    }

}
