<?php

namespace App\Events;

use App\Models\StoreOrder;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $slug;

    public function __construct(public StoreOrder $storeOrder)
    {
        $this->slug = app('currentTenant')->slug;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("stores.{$this->slug}");
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->storeOrder->id,
            'total' => 100,
            'payment_type' => 1,
            'status_label' => 'dwa',
            'neighborhood' => 'dawdaw',
            'distance' => '10',
            'ordered_since' => 'kkkkkk',
            'customer' => [
                'name' => 'Felipe'
            ]
        ];
    }

}
