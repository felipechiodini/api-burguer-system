<?php

use App\Enums\Order\Payment;

return [
    Payment::class => [
        Payment::CASH => 'Dinheiro',
        Payment::CREDIT_CARD => 'Cartão de Crédito',
        Payment::DEBIT_CARD => 'Cartão de Debito',
        Payment::PIX => 'PIX',
    ],
];
