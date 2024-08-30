<?php

namespace App\Events\frontend;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class checklistEvents
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $Pact_id, $audit_id, $tagPart_id;
    public $radiosData;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($Pact_id, $audit_id, $tagPart_id, $radiosData)
    {
        $this->Pact_id = $Pact_id;
        $this->audit_id = $audit_id;
        $this->tagPart_id = $tagPart_id;
        
        $this->radiosData = $radiosData;
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
}
