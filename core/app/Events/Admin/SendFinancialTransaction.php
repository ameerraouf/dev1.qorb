<?php

namespace App\Events\Admin;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendFinancialTransaction implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;    
    public $user_id;

    /**
     * Create a new event instance.
     */
    public function __construct($message, $user_id)
    {
        $this->message = $message;
        $this->user_id = $user_id;
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
        return 'send-transaction';
    }

    public function broadcastWith()
    {
        return [
            'data' => [
                $this->message,
                $this->user_id,
            ],
        ];
    }
}
