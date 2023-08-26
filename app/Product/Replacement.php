<?php

namespace App\Product;

use App\Models\ProductReplacement;

class Replacement {

    public $model;

    public function __construct(ProductReplacement $replacement)
    {
        $this->model = $replacement;
    }

    public function getValue()
    {
        return $this->model->value;
    }
}
