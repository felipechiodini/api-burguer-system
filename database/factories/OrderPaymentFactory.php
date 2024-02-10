<?php

namespace Database\Factories;

use App\Enums\Order\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderPaymentFactory extends Factory
{

    public function definition()
    {
        return [
            'type' => Payment::getRandomValue()
        ];
    }

}
