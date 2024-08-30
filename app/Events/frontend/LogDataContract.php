<?php

namespace App\Events\frontend;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LogDataContract implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

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
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
