<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\ProductPhoto;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductPhotoController extends Controller
{
    public function index(String $tenant, StoreProduct $product)
    {
        $page = $product->photos()
            ->paginate(10);

        return response()
            ->json(compact('page'));
    }

    public function store(StoreProduct $product, Request $request)
    {
        $request->validate([
            'photo' => 'required|image'
        ]);

        $path = Storage::disk('local')
            ->put('products', $request->file('photo'));

        $order = $product->photos()->max('order') ?? 1;

        $photo = $product->photos()
            ->create([
                'src' => $path,
                'order' => $order
            ]);

        return response()
            ->json([
                'message' => 'Foto criada com sucesso!',
                'photo' => $photo
            ]);
    }

    public function destroy(StoreProduct $product, ProductPhoto $photo)
    {
        Storage::disk('local')
            ->delete($photo->src);

        $product->photos()
            ->find($photo->id)
            ->delete();

        return response()
            ->json(['message' => 'Foto deletada com sucesso!']);
    }
}
