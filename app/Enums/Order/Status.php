<?php

namespace App\Enums\Order;

enum Status
{
    const OPEN = 1;
    const PREPARATION = 2;
    const DISPATCHED = 3;
    const DELIVERED = 4;
    const CANCELED = 5;
}
