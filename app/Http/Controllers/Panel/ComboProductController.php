<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use Illuminate\Http\Request;

class ComboProductController extends Controller
{

    public function index(Combo $combo, Request $request)
    {
        $page = $combo->options()
            ->get();

        return response()
            ->json(compact('page'));
    }

    public function store(Combo $combo, Request $request)
    {
        $combo->products()
            ->attach();

        return response()->json(['message' => 'Produtos vinculados']);
    }

}
