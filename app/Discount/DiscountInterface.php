<?php

namespace App\Discount;

interface DiscountInterface {
    public function getValue();
    public function getType();
    public function getName();
}
