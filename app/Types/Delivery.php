<?php

namespace App\Types;

use App\Enums\DeliveryType as EnumsDeliveryType;

class Delivery {

    private $type;

    public function __construct(String $type)
    {
        if ($this->isValid($type) === false) {
            throw new \Exception('Tipo de entrega inválido');
        }

        $this->type = $type;
    }

    public function isValid(String $type): bool
    {
        return EnumsDeliveryType::hasValue($type);
    }

    public function getEnum(): EnumsDeliveryType
    {
        return EnumsDeliveryType::fromValue($this->type);
    }

    public function __toString()
    {
        return $this->getEnum()->value;
    }

}
