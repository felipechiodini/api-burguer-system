<?php

namespace App\Types;

use App\Enums\Order\Delivery as OrderDelivery;

class Delivery {

    private $type;

    public function __construct(OrderDelivery $type)
    {
        $this->type = $type;
    }

    public function isValid($type): bool
    {
        return OrderDelivery::hasValue($type);
    }

    public function getEnum(): OrderDelivery
    {
        return OrderDelivery::fromValue($this->type);
    }

    public function __toString()
    {
        return $this->getEnum()->value;
    }

}
