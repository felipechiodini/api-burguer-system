<?php

namespace App\Console\Commands;

use App\Cart\Order;
use App\Enums\DeliveryType;
use App\Models\Product as ModelsProduct;
use App\Product\Product;
use Illuminate\Console\Command;

class Teste extends Command
{
    protected $signature = 'teste';

    protected $description = 'Command description';

    public function handle()
    {
        $product = new Product(ModelsProduct::query()->first());

        Order::make()
            ->setCustomer('Felipe Bona')
            ->setAddress('Arthur gonçalvez de araújo', '500')
            ->setDelivery(DeliveryType::fromValue(1), 'Entregar para o vizinho')
            ->setPayment('pix')
            ->setProduct($product)
            ->create();
    }
}
