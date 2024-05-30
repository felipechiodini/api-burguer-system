<?php

namespace App\Events;

use App\Models\UserNotification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public UserNotification $userNotification)
    {
        //
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("notifications.{$this->userNotification->user_id}"),
        ];
    }

    public function broadcastAs()
    {
        return 'notification';
    }
}
