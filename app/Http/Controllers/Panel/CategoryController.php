<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function all(Request $request)
    {
        $categories = StoreCategory::all();

        return response()
            ->json(compact('categories'));
    }

    public function index(Request $request)
    {
        $page = StoreCategory::query()
            ->paginate(10);

        return response()
            ->json(compact('page'));
    }

    public function store(Request $request)
    {
        $category = StoreCategory::create([
            'user_store_id' => app('currentTenant')->id,
            'name' => $request->name
        ]);

        return response()
            ->json([
                'message' => 'Categoria criada com sucesso!',
                'category' => $category
            ]);
    }

}
