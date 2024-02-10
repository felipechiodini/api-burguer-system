<?php

namespace App\Enums\Order;

use BenSampo\Enum\Attributes\Description;
use BenSampo\Enum\Enum;

final class Delivery extends Enum
{
    #[Description('Entrega')]
    const DELIVERY = 1;
    #[Description('Retirada')]
    const WITHDRAW = 2;
    #[Description('Mesa')]
    const ON_SITE = 3;
}
