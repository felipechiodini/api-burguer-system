<?php

namespace Database\Seeders;

use App\Models\DeliveryType;
use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{

    public function run()
    {
        PaymentType::create(['id' => 'pix', 'name' => 'Pix']);
        PaymentType::create(['id' => 'cash', 'name' => 'Dinheiro']);
        PaymentType::create(['id' => 'credit-card', 'name' => 'Cartão de Crédito']);
        PaymentType::create(['id' => 'debit-card', 'name' => 'Cartão de Débito']);

        DeliveryType::create(['id' => 'delivery', 'name' => 'Entrega']);
        DeliveryType::create(['id' => 'withdraw', 'name' => 'Retirada']);
    }

}
