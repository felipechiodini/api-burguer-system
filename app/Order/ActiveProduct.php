<?php

namespace App\Cart;

use App\Models\Product;

class ActiveProduct {

    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function active()
    {
        $errors = collect();

        if ($this->product->photos()->count() === 0) {
            $errors->push('É necessário que o produto tenha uma foto');
        }

        if ($this->product->getCurrentPrice() === null) {
            $errors->push('O produto não possue preço');
        }

        if ($this->product->category() === null) {
            $errors->push('O produto não possue categoria');
        }

        if ($errors->count() > 0) {
            return $errors;
        }

        $this->product->update([
            'active' => true
        ]);
    }
}
