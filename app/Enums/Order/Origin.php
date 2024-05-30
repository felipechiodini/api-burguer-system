<?php declare(strict_types=1);

namespace App\Enums\Order;

use BenSampo\Enum\Enum;

final class Origin extends Enum
{
    const APP = 1;
    const WAITER = 2;
    const ADMIN = 3;
}
