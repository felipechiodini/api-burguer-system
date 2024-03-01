<?php

namespace App\Types;

use App\Enums\Order\Payment as OrderPayment;

class Payment {

    private $type;

    public function __construct($type)
    {
        if ($this->isValid($type) === false) {
            throw new \Exception('Tipo de pagamento inválido');
        }

        $this->type = $type;
    }

    public function isValid($type): Bool
    {
        return OrderPayment::hasValue($type);
    }

    public function getEnum(): OrderPayment
    {
        return OrderPayment::fromValue($this->type);
    }

    public function __toString()
    {
        return $this->getEnum()->value;
    }

}
