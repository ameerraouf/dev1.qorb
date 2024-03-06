<?php

namespace App\Events\Teacher;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SupervisorAddVbmap implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $children;
    public $t_id;

    /**
     * Create a new event instance.
     */
    public function __construct($children, $t_id)
    {
        $this->children = $children;
        $this->t_id = $t_id;
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
        return 'supervisor-add-vbmap';
    }

    public function broadcastWith()
    {
        return [
            'data' => [
                $this->children,
                $this->t_id,
            ],
        ];
    }
}
