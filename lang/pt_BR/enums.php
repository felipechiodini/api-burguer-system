<?php

use App\Enums\Order\Delivery;
use App\Enums\Order\Payment;
use App\Enums\Order\Status;

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
    Status::class => [
        Status::OPEN => 'Aberto',
        Status::PREPARATION => 'Preparação',
        Status::DISPATCHED => 'Despachado',
        Status::DELIVERED => 'Entregue',
        Status::CANCELED => 'Cancelado',
    ],
];
