<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreProduct;
use App\Table\Filters\Text;
use App\Table\Table;
use App\Utils\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $builder = StoreProduct::query();

        $table = Table::make()
            ->setEloquentBuilder($builder)
            ->addColumn('Imagem')
            ->addColumn('Nome')
            ->addColumn('Preço de')
            ->addFilter(new Text('name', 'Nome'))
            ->addFilter(new Text('src', 'Imagem'))
            ->addModifier('price', fn($value) => Helper::formatCurrency($value))
            ->addModifier('price_from', fn($value) => Helper::formatCurrency($value))
            ->setPerPage($request->per_page)
            ->get();

        return response()
            ->json($table);
    }

    public function store(string $slug, Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'image' => 'required|image',
            'name' => 'required',
            'price' => 'required',
            'description' => 'required'
        ]);

        $path = $request->file('image')
            ->store('products');

        $product = StoreProduct::query()
            ->create([
                'category_id' => $request->category_id,
                'image' => $path,
                'active' => true,
                'name' => $request->name,
                'price' => $request->price,
                'price_from' => $request->price_from,
                'description' => $request->description
            ]);

        Cache::forget("store-$slug");

        return response()
            ->json([
                'message' => 'Produto criado com sucesso!',
                'product' => $product
            ]);
    }

    public function show(String $tenant, StoreProduct $product)
    {
        return response()
            ->json(compact('product'));
    }

    public function update(String $tenant, StoreProduct $product, Request $request)
    {
        $request->validate([
            'active' => 'required|boolean',
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $product->update([
            'active' => $request->active,
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()
            ->json(['message' => 'Produto atualizado com sucesso']);
    }

    public function destroy(StoreProduct $product)
    {
        $product->delete();

        return response()
            ->json(['message' => 'Produto deletado']);
    }
}
