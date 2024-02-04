<?php

namespace App\Types;

use App\Enums\OrderPaymentType;

class Payment {

    private $type;

    public function __construct(String $type)
    {
        if ($this->isValid($type) === false) {
            throw new \Exception('Tipo de pagamento inválido');
        }

        $this->type = $type;
    }

    public function isValid(String $type): bool
    {
        return OrderPaymentType::hasValue($type);
    }

    public function getEnum(): OrderPaymentType
    {
        return OrderPaymentType::fromValue($this->type);
    }

    public function __toString()
    {
        return $this->getEnum()->value;
    }

}
