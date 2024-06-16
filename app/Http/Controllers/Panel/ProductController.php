<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\ProductPhoto;
use App\Models\StoreProduct;
use App\Table\Filters\Text;
use App\Table\Table;
use App\Utils\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $builder = StoreProduct::query()
            ->select('store_products.id', 'store_products.name', 'product_photos.src', 'price_from', 'price_to')
            ->leftJoin('product_photos', fn($join) => $join->on('product_photos.store_product_id', 'store_products.id'));

        $table = Table::make()
            ->setEloquentBuilder($builder)
            ->addColumn('Imagem')
            ->addColumn('Nome')
            ->addColumn('Preço de')
            ->addColumn('Preço por')
            ->addFilter(new Text('name', 'Nome'))
            ->addFilter(new Text('src', 'Imagem'))
            ->addModifier('price_from', fn($value) => Helper::formatCurrency($value))
            ->addModifier('price_to', fn($value) => Helper::formatCurrency($value))
            ->setPerPage($request->per_page)
            ->get();

        return response()
            ->json($table);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'description' => 'required'
        ]);

        $path = $request->file('photo')->store('dwads');

        $product = StoreProduct::query()
            ->create([
                'store_category_id' => $request->category_id,
                'photo' => $path,
                'active' => true,
                'name' => $request->name,
                'price_from' => $request->price,
                'description' => $request->description
            ]);

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
