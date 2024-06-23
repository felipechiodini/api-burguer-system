<?php

namespace App\Events;

use App\Models\StoreOrder;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderDispatched
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public StoreOrder $storeOrder)
    {
        //
    }

    public function broadcastOn(): array
    {
        return [
            new Channel("order.{$this->storeOrder->id}"),
        ];
    }
}
