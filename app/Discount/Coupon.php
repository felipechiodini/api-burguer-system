<?php

namespace App\Discount;

use App\Models\Coupon as ModelsCoupon;

class Coupon implements DiscountInterface {

    public $model;

    public function __construct(ModelsCoupon $coupon)
    {
        $this->model = $coupon;
    }

    public function getName()
    {
        return 'Cupom';
    }

    public function getValue()
    {
        return $this->model->value;
    }

    public function getType()
    {
        return $this->model->type;
    }
}
