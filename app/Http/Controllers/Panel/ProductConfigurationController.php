<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductConfigurationController extends Controller
{
    public function createOrUpdate(Product $product, Request $request)
    {
        $request->validate([
            'unit_type' => 'required|in:grams,unit',
            'max_number_replacements' => 'required|integer',
            'max_number_additionals' => 'required|integer',
        ]);

        $product->configuration()
            ->createOrUpdate([
                'unit_type' => $request->unit_type,
                'max_number_replacements' => $request->max_number_replacements,
                'max_number_additionals' => $request->max_number_additionals,
            ]);

        return response()
            ->json(['message' => 'Configuração salva com sucesso!']);
    }
}
