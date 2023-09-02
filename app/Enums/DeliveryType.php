<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class DeliveryType extends Enum
{
    const DELIVERY = 1;
    const WITHDRAW = 2;
    const ON_SITE = 3;
}
