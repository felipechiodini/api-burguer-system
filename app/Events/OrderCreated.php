<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct()
    {
        //
    }

    public function broadcastOn()
    {
        return new PrivateChannel('notifications.1');
    }

    public function broadcastAs()
    {
        return 'notification';
    }

    public function broadcastWith()
    {
        return [
            'message' => 'kkkkkkkkkkkkk'
        ];
    }

}
