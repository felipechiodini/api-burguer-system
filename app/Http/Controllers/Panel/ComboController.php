<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use Illuminate\Http\Request;

class ComboController extends Controller
{

    public function index()
    {
        $page = Combo::query()
            ->paginate(10);

        return response()
            ->json(compact('page'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:5'
        ]);

        $combo = Combo::query()
            ->create([
                'name' => $request->name
            ]);

        return response()
            ->json([
                'message' => 'Combo criado com sucesso!',
                'combo' => $combo
            ]);
    }

    public function update(Combo $combo, Request $request)
    {
        $request->validate([
            'name' => 'string|min:5'
        ]);

        $combo->update([
            'name' => $request->name
        ]);

        return response()
            ->json([
                'message' => 'Combo atualizado com sucesso!',
            ]);
    }

    public function destroy(Combo $combo)
    {
        $combo->delete();

        return response()
            ->json([
                'message' => 'Combo deletado com sucesso!'
            ]);
    }

}
