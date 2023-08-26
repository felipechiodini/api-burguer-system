<?php

namespace App\Console\Commands;

use App\Cart\Cart;
use App\Models\Cart as ModelsCart;
use App\Models\CartItem;
use Illuminate\Console\Command;

class Teste extends Command
{
    protected $signature = 'teste';

    protected $description = 'Command description';

    public function handle()
    {
        $cart = new Cart(ModelsCart::first());

        $cart->save();

        dd($cart::load());

    }
}
