<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\ProductPhoto;
use App\Models\StoreProduct;
use Illuminate\Http\Request;

class ProductPhotoController extends Controller
{

    public function store(String $tenant, StoreProduct $product, Request $request)
    {
        $request->validate([
            'photo' => 'required|image'
        ]);

        $path = $request->file('photo')
            ->store('product_photos');

        ProductPhoto::query()
            ->create([
                'store_product_id' => $product->id,
                'src' => $path,
                'order' => ProductPhoto::max('order') + 1 ?? 1
            ]);

        return response()
            ->json(['message' => 'Foto salva com sucesso!']);
    }

}
