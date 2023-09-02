<?php

namespace App\Product;

use App\Models\Product as ModelsProduct;

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

    public function getValue()
    {
        $additionalPrice = 0;
        foreach ($this->additionals as $additional) {
            $additionalPrice =+ $additional->getValue();
        }

        $replacementPrice = 0;
        foreach ($this->replacements as $replacement) {
            $replacementPrice =+ $replacement->getValue();
        }

        return $this->model->getCurrentPrice()->value + $additionalPrice + $replacementPrice;
    }

    public function addAdditional(Additional $additional)
    {
        $this->additionals->push($additional);
        return $this;
    }

    public function addReplacement(Replacement $replacement)
    {
        $this->replacements->push($replacement);
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