<?php

namespace App\Events\frontend;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MsTeamsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

     public  $PactCon_id,$userPost,$passwordPost,$userTag,$passwordTag,$nameTag,$group_id,$teams_chanel,$Msteams_Id,$dataArray,$type_team,$statusPost;

  
    public function __construct($PactCon_id,$userPost,$passwordPost,$userTag,$passwordTag,$nameTag,$group_id,$teams_chanel,$Msteams_Id,$dataArray,$type_team,$statusPost)
    {
        $this->PactCon_id = $PactCon_id;
        $this->userPost = $userPost;
        $this->passwordPost = $passwordPost;
        $this->userTag = $userTag;
        $this->passwordTag = $passwordTag;
        $this->nameTag = $nameTag;
        $this->group_id = $group_id;
        $this->teams_chanel = $teams_chanel;        
        $this->Msteams_Id = $Msteams_Id;
        $this->dataArray = $dataArray;
        $this->type_team = $type_team;
        $this->statusPost = $statusPost;
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
