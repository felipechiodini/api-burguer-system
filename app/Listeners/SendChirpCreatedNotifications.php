<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendChirpCreatedNotifications implements ShouldQueue
{

    public function handle(OrderCreated $event): void
    {

    }

}
