<?php

namespace App\Enums\Order;

use BenSampo\Enum\Attributes\Description;
use BenSampo\Enum\Enum;

final class Origin extends Enum
{
    #[Description('Cardapio Online')]
    const APP = 1;
    #[Description('Garçon')]
    const WAITER = 2;
    #[Description('Manual')]
    const ADMIN = 3;
}
