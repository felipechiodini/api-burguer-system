<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use App\Models\ComboOption;
use Illuminate\Http\Request;

class ComboOptionController extends Controller
{

    public function index(Combo $combo)
    {
        $page = $combo->options()
            ->paginate(10);

        return response()
            ->json(compact('page'));
    }

    public function store(Combo $combo, Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:5'
        ]);

        $order = $combo->options()->max('order') ?? 1;

        // dd($combo);

        $combo->options()
            ->create([
                'combo_id' => $combo->id,
                'order' => $order
            ]);

        return response()
            ->json([
                'message' => 'Opção criada com sucesso!'
            ]);
    }

    public function update(Combo $combo, ComboOption $comboOption, Request $request)
    {
        $request->validate([
            'name' => 'string|min:5'
        ]);

        $comboOption->update([
            'value' => $request->name
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
