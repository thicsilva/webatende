<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CallCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $call;

    public function __construct($call)
    {
        $this->call = $call;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['events'];
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->call->id,
            'customer' => [
                'name' =>$this->call->customer->name,
            ],
            'contact' => $this->call->contact,
            'status' => $this->call->status,
            'fromUser' => [
                'id' => $this->call->from_user_id,
                'name' => $this->call->fromUser->name,
                'avatar' => $this->call->fromUser->avatar,
            ],
            'toUser' => [
                'id' => $this->call->to_user_id,
                'name' => $this->call->toUser->name,
            ],
            'created_at' => $this->call->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->call->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
