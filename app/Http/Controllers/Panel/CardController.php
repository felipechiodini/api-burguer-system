<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\UserStore;
use Illuminate\Http\Request;

class CardController extends Controller
{

    public function index()
    {
        return response()->json(Card::paginate(20));
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|numeric'
        ]);

        $card = Card::create([
            'user_store_id' => $request->header(UserStore::HEADER_KEY),
            'number' => $request->number
        ]);

        return response()->json(['message' => 'Criado com sucesso!', 'card' => $card]);
    }

}
