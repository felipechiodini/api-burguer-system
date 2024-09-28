<?php declare(strict_types=1);

namespace App\Enums\Order;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class Status extends Enum implements LocalizedEnum
{
    const OPEN = 1;
    const PREPARATION = 2;
    const DISPATCHED = 3;
    const DELIVERED = 4;
    const CANCELED = 5;
}
