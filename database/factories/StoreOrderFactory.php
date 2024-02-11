<?php

namespace Database\Factories;

use App\Enums\Order\Origin;
use App\Enums\Order\Status;
use App\Models\StoreCustomer;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreOrderFactory extends Factory
{

    public function definition()
    {
        $price = collect([
          [
            'products_total' => 100,
            'delivery_fee' => 20,
            'discount' => 0,
            'total' => 120,
          ],
          [
            'products_total' => 200,
            'delivery_fee' => 0,
            'discount' => 50,
            'total' => 150,
          ],
          [
            'products_total' => 70,
            'delivery_fee' => 30,
            'discount' => 0,
            'total' => 100,
          ]
        ])->random();

        return [
            'store_customer_id' => StoreCustomer::all()->random()->id,
            'status' => Status::OPEN,
            'origin' => Origin::APP,
            'products_total' => $price['products_total'],
            'delivery_fee' => $price['delivery_fee'],
            'discount' => $price['discount'],
            'total' => $price['total']
        ];
    }

}
