<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\UserStore;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function all(Request $request)
    {
        $categories = Category::all();

        return response()
            ->json(compact('categories'));
    }

    public function index(Request $request)
    {
        $page = Category::query()
            ->paginate(10);

        return response()
            ->json(compact('page'));
    }

    public function store(Request $request)
    {
        $category = Category::create([
            'user_store_id' => UserStore::query()->first()->id,
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Categoria criada com sucesso!',
            'category' => $category
        ]);
    }

}
