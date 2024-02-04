<?php

namespace App\Order;

use App\Models\StoreProduct;

class OrderProduct {

    public $model;
    public $amount;
    public $additionals;
    public $replacements;
    public $observation;

    public function __construct(StoreProduct $product, Int $amount = 1)
    {
        $this->model = $product;
        $this->amount = $amount;
        $this->additionals = collect([]);
        $this->replacements = collect([]);
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

        return $this->model->getCurrentPrice()->current + $additionalPrice + $replacementPrice;
    }

}
