<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\ProductPhoto;
use App\Models\ProductPrice;
use App\Models\StoreProduct;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $request->validate([
            'term' => 'string|nullable'
        ]);

        $page = StoreProduct::query()
            ->when($request->query('term'), function($query, String $term) {
                $query->where('name', $term);
            })
            ->orderBy('id', 'desc')
            ->paginate();

        return response()
            ->json(compact('page'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $product = StoreProduct::create([
            'user_store_id' => app('currentTenant')->id,
            'store_category_id' => $request->category_id,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description
        ]);

        foreach ($request->photos as $index => $photo) {
            $path = Storage::put('products', $photo);

            ProductPhoto::query()
                ->create([
                    'store_product_id' => $product->id,
                    'src' => $path,
                    'order' => $index + 1
                ]);
        }

        ProductPrice::query()
            ->create([
                'store_product_id' => $product->id,
                'value' => $request->price,
                'start_date' => now(),
                'end_date' => now()
            ]);

        DB::commit();

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
