<?php

namespace App\Console\Commands;

use App\Events\OrderCreated;
use App\Models\UserNotification;
use Illuminate\Console\Command;

class Teste extends Command
{
    protected $signature = 'teste';

    protected $description = 'Command description';

    public function handle()
    {
        UserNotification::query()->create([
            'user_id' => 1,
            'title' => 'eai irmão',
            'content' => 'vai se foderu maluko'
        ]);
    }
}
