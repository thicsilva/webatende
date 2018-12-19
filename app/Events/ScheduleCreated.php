<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ScheduleCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $schedule;

    public function __construct($schedule)
    {
        $this->schedule = $schedule;
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
            'id' => $this->schedule->id,
            'customer' => [
                'name' => $this->schedule->customer->name
            ],
            'description' => $this->schedule->description,
            'fromUser' => [
                'name' => $this->schedule->fromUser->name,
                'avatar' => $this->schedule->fromUser->avatar,
            ],
            'toUser' => [
                'id' => $this->schedule->to_user_id,
                'name' => optional($this->schedule->toUser)->name,
                'avatar' => optional($this->schedule->toUser)->avatar,
            ],
            'initial' => $this->schedule->initial_date->format('d/m/Y \à\s H:i'),
            'final' => $this->schedule->final_date->format('d/m/Y \à\s H:i')
        ];
    }
}
