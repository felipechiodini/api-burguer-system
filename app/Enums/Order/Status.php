<?php

namespace App\Enums\Order;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Attributes\Description;

final class Status extends Enum
{
    #[Description('Em Aberto')]
    const OPEN = 1;
    #[Description('Em Preparação')]
    const PREPARATION = 2;
    #[Description('Despachado')]
    const DISPATCHED = 3;
    #[Description('Entregue')]
    const DELIVERED = 4;
    #[Description('Cancelado')]
    const CANCELED = 5;
}
