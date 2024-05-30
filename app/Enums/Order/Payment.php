<?php declare(strict_types=1);

namespace App\Enums\Order;

use BenSampo\Enum\Enum;

final class Payment extends Enum
{
    const CASH = 1;
    const CREDIT_CARD = 2;
    const DEBIT_CARD = 3;
    const PIX = 4;
}
