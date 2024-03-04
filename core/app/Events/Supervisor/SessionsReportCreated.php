<?php

namespace App\Events\Supervisor;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SessionsReportCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $children;
    public $s_id;

    /**
     * Create a new event instance.
     */
    public function __construct($children, $s_id)
    {
        $this->children = $children;
        $this->s_id = $s_id;
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
        return 'sessions-report-created';
    }

    public function broadcastWith()
    {
        return [
            'data' => [
                $this->children,
                $this->s_id,
            ],
        ];
    }
}
