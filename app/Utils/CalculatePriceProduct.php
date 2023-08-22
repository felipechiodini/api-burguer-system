<?php

namespace App\Product;

use App\Models\Product;
use Exception;

class CalculatePriceProduct {

    private $product;
    private $additionals;
    private $replacements;

    private function __construct(Product $product)
    {
        $this->product = $product;
        $this->additionals = collect([]);
        $this->replacements = collect([]);
    }

    public static function product(Product $product)
    {
        return new static($product);
    }

    public function getPrice()
    {
        $totalPrice = 0;

        if ($this->hasReplacements()) {
            foreach ($this->replacements as $replacement) {
                $totalPrice = $totalPrice + $replacement->value;
            }
        }

        if ($this->hasAdditionals()) {
            foreach ($this->additionals as $additional) {
                $totalPrice = $totalPrice + ($additional->value * $additional->times);
            }
        }

        return $totalPrice;
    }

    public function replacements($replacements)
    {
        foreach ($replacements as $replacement) {
            $this->replacement($replacement);
        }

        return $this;
    }

    public function replacement($replacement)
    {
        $replacement = $this->product
            ->replacements
            ->find($replacement['id']);

        if (!$replacement) throw new Exception('Replacement not found');

        $this->replacements->push($replacement);

        return $this;
    }

    public function hasReplacements()
    {
        return $this->replacements->count() > 0;
    }

    public function additionals($additionals)
    {
        foreach ($additionals as $additional) {
            $this->additional($additional);
        }

        return $this;
    }

    public function additional($additional)
    {
        $additional = $this->product
            ->additionals
            ->find($additional['id']);

        if (!$additional) throw new Exception('Additional not found!');

        $additional->times = 1;

        $this->additionals->push($additional);

        return $this;
    }

    public function hasAdditionals()
    {
        return $this->additionals->count() > 0;
    }

}
