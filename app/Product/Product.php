<?php

namespace App\Product;

use App\Models\Product as ModelsProduct;
use App\Models\ProductAdditional;
use App\Models\ProductReplacement;

class Product {

    public $model;
    public $additionals;
    public $replacements;

    public function __construct(ModelsProduct $product)
    {
        $this->model = $product;
        $this->additionals = collect([]);
        $this->replacements = collect([]);
    }

    public function getPrice()
    {
        $additionalPrice = 0;
        foreach ($this->additionals as $additional) {
            $additionalPrice =+ $additional->getValue();
        }

        $replacementPrice = 0;
        foreach ($this->replacements as $replacement) {
            $replacementPrice =+ $replacement->getValue();
        }

        return $this->model->price + $additionalPrice + $replacementPrice;
    }

    public function addAdditional(ProductAdditional $additional, Int $amount = 1)
    {
        $exists = $this->model
            ->additionals()
            ->where('id', $additional->id)
            ->exists();

        if ($exists === false)
            throw new \Exception("Adicional {$additional->id} não permitido!");

        $this->additionals->push(new Additional($additional, $amount));

        return $this;
    }

    public function addReplacement(ProductReplacement $replacement)
    {
        $exists = $this->model
            ->replacements()
            ->where('id', $replacement->id)
            ->exists();

        if ($exists === false)
            throw new \Exception("Substituição {$replacement->id} não permitida!");

        $this->replacements->push(new Replacement($replacement));

        return $this;
    }

    public function hasReplacement(): bool
    {
        return $this->replacements->count() > 0;
    }

    public function hasAdditional(): bool
    {
        return $this->additionals->count() > 0;
    }
}
