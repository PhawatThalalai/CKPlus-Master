<?php

namespace App\Events\frontend;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LogDataCusTag
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public  $Data_id, $Status, $Model, $Taginput, $Detail, $User;
    public function __construct($Data_id, $Status, $Model, $Taginput, $Detail, $User)
    {
        $this->Data_id = $Data_id;
        $this->Status = $Status;
        $this->Model = $Model;        
        $this->Taginput = $Taginput;
        $this->Detail = $Detail;
        $this->User = $User;
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
