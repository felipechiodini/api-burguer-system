<?php

namespace App\Enums\Order;

enum Payment
{
    const CASH = 1;
    const CREDIT_CARD = 2;
    const DEBIT_CARD = 3;
    const PIX = 4;
}
