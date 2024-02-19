<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreCategory;
use App\Table\Filters\Text;
use App\Table\Table;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function all(Request $request)
    {
        $categories = StoreCategory::query()
            ->select('id', 'name')
            ->get();

        return response()
            ->json(compact('categories'));
    }

    public function index(Request $request)
    {
        $builder = StoreCategory::query()
            ->select('id', 'name');

        $table = Table::make()
            ->setEloquentBuilder($builder)
            ->addColumn('Nome')
            ->addFilter(new Text('name', 'Nome'))
            ->setPerPage($request->per_page)
            ->get();

        return response()
            ->json($table);
    }

    public function show(String $tenant, StoreCategory $category)
    {
        return response()
            ->json(compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        StoreCategory::create([
            'user_store_id' => app('currentTenant')->id,
            'name' => $request->name,
            'order' => StoreCategory::query()->max('order')
        ]);

        return response()
            ->json(['message' => 'Categoria criada com sucesso!']);
    }

    public function update(String $tenant, StoreCategory $category, Request $request)
    {
        $request->validate([
            'name' => 'string'
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return response()
            ->json(['message' => 'Categoria atualizada com sucesso!']);
    }

    public function destroy(String $tenant, StoreCategory $category)
    {
        $category->delete();

        return response()
            ->json(['message' => 'Categoria excluída com sucesso!',]);
    }

}
