<?php

namespace App\Utils;

use App\Models\ProductItem;

class Item {

    private $model;

    public function __construct(ProductItem $productItem)
    {
        $this->model = $productItem;
    }

    public static function make($id)
    {
        $model = ProductItem::query()
            ->findOrFail($id);

        return new static($model);
    }

    public function getValue(): int
    {
        return $this->model->value;
    }

    public function hasStock(): bool
    {
        return $this->model->stock > 0;
    }
}
