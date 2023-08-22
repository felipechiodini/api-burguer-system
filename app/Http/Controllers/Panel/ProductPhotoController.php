<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductPhotoController extends Controller
{
    public function index(Product $product)
    {
        $page = $product->photos()
            ->paginate(10);

        return response()
            ->json(compact('page'));
    }

    public function store(Product $product, Request $request)
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

    public function destroy(Product $product, ProductPhoto $productPhoto)
    {
        Storage::disk('local')
            ->delete($productPhoto->src);

        $product->photos()
            ->find($productPhoto->id)
            ->delete();

        return response()
            ->json(['message' => 'Foto deletada com sucesso!']);
    }
}
