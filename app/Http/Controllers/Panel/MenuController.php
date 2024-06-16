<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreCategory;
use App\Models\StoreProduct;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    public function index(Request $request)
    {
        $menu = StoreCategory::query()
            ->get()
            ->map(function(StoreCategory $category) {
                $category->products = StoreProduct::query()
                    ->where('store_category_id', $category->id)
                    ->get();
            });

        return response()
            ->json(compact('menu'));
    }

}
