<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderPaymentType extends Enum
{
    const CASH = 'cash';
    const CREDIT_cARD = 'credit-card';
    const DEBIT_CARD = 'debit-card';
    const PIX = 'pix';
}
