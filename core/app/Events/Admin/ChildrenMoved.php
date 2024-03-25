<?php

namespace App\Events\Admin;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChildrenMoved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message, $specialist_id, $supervisor_id;
    /**
     * Create a new event instance.
     */
    public function __construct($message, $specialist_id, $supervisor_id)
    {
        $this->message       = $message;            
        $this->specialist_id = $specialist_id;
        $this->supervisor_id = $supervisor_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('qorb-channel'),
        ];
    }

    public function broadcastAs()
    {
        return 'child-moved';
    }

    public function broadcastWith()
    {
        return [
            'data' => [
                $this->message,
                $this->specialist_id,
                $this->supervisor_id,
            ],
        ];
    }
}
