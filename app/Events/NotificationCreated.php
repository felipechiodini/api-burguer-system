<?php

namespace App\Events;

use App\Models\UserNotification;
use Carbon\Carbon;
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

    public function broadcastWith()
    {
        return [
            'notification' => [
                'id' => $this->userNotification->id,
                'title' => $this->userNotification->title,
                'content' => $this->userNotification->content,
                'read' => $this->userNotification->read,
                'created_at' => Carbon::parse($this->userNotification->created_at)->format('d/m/Y H:i')
            ]
        ];
    }
}
