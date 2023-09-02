<?php

namespace App\Console\Commands;

use App\Cart\Order;
use App\Enums\DeliveryType;
use App\Models\Product as ModelsProduct;
use App\Product\Product;
use App\Utils\Helper;
use Illuminate\Console\Command;

class Teste extends Command
{
    protected $signature = 'teste';

    protected $description = 'Command description';

    public function handle()
    {
        $cordinates = Helper::coordinatesByCep('89253390');

        $distance = Helper::distanceBetweenTwoCoordinates(
            '-26.5050371',
            '-49.097304',
            $cordinates->latitude,
            $cordinates->longitude
        );
    }
}
