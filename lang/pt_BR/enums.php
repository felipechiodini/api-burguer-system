<?php

use App\Enums\Order\Delivery;
use App\Enums\Order\Payment;

return [
    Payment::class => [
        Payment::CASH => 'Dinheiro',
        Payment::CREDIT_CARD => 'Cartão de Crédito',
        Payment::DEBIT_CARD => 'Cartão de Debito',
        Payment::PIX => 'PIX',
    ],
    Delivery::class => [
        Delivery::DELIVERY => 'Entrega',
        Delivery::WITHDRAW => 'Retirada',
        // Delivery::ON_SITE => 'No Local',
    ],
];
