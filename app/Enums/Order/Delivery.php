<?php declare(strict_types=1);

namespace App\Enums\Order;

use BenSampo\Enum\Enum;

final class Delivery extends Enum
{
    const DELIVERY = 1;
    const WITHDRAW = 2;
    const ON_SITE = 3;
}
