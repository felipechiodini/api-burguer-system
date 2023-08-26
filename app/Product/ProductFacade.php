<?php

namespace App\Product;

use Illuminate\Support\Facades\Facade;

class ProductFacade extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'product';
    }
}
