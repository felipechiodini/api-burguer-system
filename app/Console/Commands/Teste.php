<?php

namespace App\Console\Commands;

use App\Events\OrderCreated;
use Illuminate\Console\Command;

class Teste extends Command
{
    protected $signature = 'teste';

    protected $description = 'Command description';

    public function handle()
    {
        OrderCreated::dispatch();
    }
}
