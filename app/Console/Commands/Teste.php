<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Product;

class Teste extends Command
{
    protected $signature = 'teste';

    protected $description = 'Command description';

    public function handle()
    {

        Product::greet();


    }
}
