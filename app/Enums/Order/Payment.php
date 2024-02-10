<?php

namespace App\Enums\Order;

use BenSampo\Enum\Attributes\Description;
use BenSampo\Enum\Enum;

final class Payment extends Enum
{
    #[Description('Dinheiro')]
    const CASH = 1;
    #[Description('Cartão de Crédito')]
    const CREDIT_cARD = 2;
    #[Description('Cartão Débito')]
    const DEBIT_CARD = 3;
    #[Description('Pix')]
    const PIX = 4;
}
