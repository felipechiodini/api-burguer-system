<?php

namespace App\Utils;

use App\Models\Product as ModelsProduct;

class Product {

    public $model;

    public function __construct(ModelsProduct $product)
    {
        $this->model = $product;
    }

    public function getCurrentPrice()
    {

    }

}
