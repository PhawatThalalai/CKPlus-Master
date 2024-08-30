<?php

namespace App\Events\backend;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventPayments
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $someCondition, $status, $PatchCont, $_CONTSTAT;
    public function __construct($someCondition, $status, $PatchCont, $_CONTSTAT = NULL)
    {
        $this->status = $status;
        $this->someCondition = $someCondition;
        $this->PatchCont = $PatchCont;
        $this->_CONTSTAT = $_CONTSTAT;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
