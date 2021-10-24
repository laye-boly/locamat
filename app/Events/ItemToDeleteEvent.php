<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ItemToDeleteEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $ids;
    private $action;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $ids, $action)
    {
        $this->ids = $ids;
        $this->action = $action;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    public function getIds(){
        return $this->ids;
    }

    public function getAction(){
        return $this->action;
    }
}
