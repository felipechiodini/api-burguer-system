<?php

namespace App\Http\Controllers\Panel;

use App\Enums\Order\Delivery;
use App\Enums\Order\Payment;
use App\Http\Controllers\Controller;
use App\Models\StoreDelivery;
use App\Models\StorePayment;
use App\Models\UserStore;
use App\Utils\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function update(String $slug, Request $request)
    {
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ];

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos');
        }

        UserStore::query()
            ->where('slug', $slug)
            ->update($data);

        return response()
            ->json([
                'message' => 'Loja atualizada com sucesso'
            ]);
    }

    public function get(String $slug)
    {
        $store = app('currentTenant');

        $store = [
            'name' => $store->name,
            'slug' => $store->slug,
            'logo' => Helper::makeStoragePath($store->logo),
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

        if (UserStore::canUseName($request->name)) {
            return response()->json(['message' => 'Não é possivel utilizar este nome'], 422);
        }

        $store = UserStore::query()
            ->create([
                'user_id' => $request->user()->id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'logo' => ''
            ])->makeCurrent();

        foreach (Payment::getInstances() as $payment) {
            StorePayment::query()
                ->create([
                    'active' => false,
                    'type' => $payment->value
                ]);
        }

        foreach (Delivery::getInstances() as $delivery) {
            StoreDelivery::query()
                ->create([
                    'active' => false,
                    'type' => $delivery->value
                ]);
        }

        return response()
            ->json(compact('store'));
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'image'
        ]);

        $path = $request->file('logo')
            ->store('logos');

        app('currentTenant')
            ->update(['logo' => $path]);

        return response()
            ->json(['message' => 'Logo atualizada com sucesso']);
    }
}
