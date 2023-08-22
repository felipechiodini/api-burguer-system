<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function get()
    {
        $categories = Category::with([
            'products' => function($query) {
                $query->where('active', true);
            },
            'products.photos',
            'products.additionals',
            'products.replacements',
            'products.followup',
            'products.configuration'
        ])
        ->get();

        return response()->json($categories);
    }

    public function show($product, Request $request)
    {
        $product = Product::with('photos', 'additionals', 'replacements')
            ->where('id', $product)
            ->first();

        return response()->json($product);
    }

}
