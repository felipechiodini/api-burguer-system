<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderOrigin extends Enum
{
    const CUSTOMER = 1;
    const WAITER = 2;
    const ADMIN = 3;
}
