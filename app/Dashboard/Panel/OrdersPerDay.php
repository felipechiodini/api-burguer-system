<?php

namespace App\Dashboard\Panel;

use App\Dashboard\Chart;

class OrdersPerDay extends Chart {

    public function getName(): string
    {
        return 'Pedidos por Dia';
    }


}
