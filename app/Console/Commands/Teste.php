<?php

namespace App\Console\Commands;

use App\Cart\Cart;
use Illuminate\Console\Command;

class Teste extends Command
{
    protected $signature = 'teste';

    protected $description = 'Command description';

    public function handle()
    {
        $cart = Cart::load(1);

        $cart->removeItem();

    }
}
