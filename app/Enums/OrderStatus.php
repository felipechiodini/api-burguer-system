<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderStatus extends Enum
{
    const OPEN = 1;
    const PREPARATION = 2;
    const SHIPPED = 3;
    const DELIVERED = 4;
    const CANCELED = 5;
}
