<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Teste extends Command
{
    protected $signature = 'teste';

    protected $description = 'Command description';

    public function handle()
    {
        event(new \App\Events\SendMessage('Hello'));
    }
}
