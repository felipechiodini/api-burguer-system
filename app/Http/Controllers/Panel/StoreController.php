<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\UserStore;
use Illuminate\Http\Request;
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

    public function update(String $slug, Request $request)
    {
        $request->validate([
            'name' => 'string',
            'logo' => 'image'
        ]);

        $data = [];

        $request->whenHas('name', function() use(&$data, &$request) {
            $this->canUseName($request->name);

            $data['name'] = $request->name;
            $data['slug'] = Str::slug($request->name);
        });

        $request->whenHas('logo', function() use(&$data, &$request) {
            $data['logo'] = $request->file('logo')
                ->store('logos');
        });

        UserStore::query()
            ->where('slug', $slug)
            ->update($data);

        return response()
            ->json(['message' => 'Loja atualizada com sucesso']);
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

        $this->canUseName($request->name);

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

    private function canUseName($name)
    {
        $exists = UserStore::query()
            ->where('slug', Str::slug($name))
            ->exists();

        if ($exists) throw new \Exception('Não é possivel utilizar este nome');
    }

}
