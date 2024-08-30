<?php

namespace App\Listeners\frontend;

use App\Events\frontend\MsTeamsEvent;
use App\Models\TB_PactContracts\Pact_AuditTags;
use App\Models\TB_PactContracts\Pact_Contracts;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Microsoft\Graph\Model;
use ConnectMSTeams;
class MsTeamsListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\frontend\MsTeamsEvent  $event
     * @return void
     */
    public function handle(MsTeamsEvent $event)
    {

        $tokenUser = ConnectMSTeams::getTokenUser($event->userPost, $event->passwordPost);
        $tokenUserTag = ConnectMSTeams::getTokenUser($event->userTag, $event->passwordTag);
        // dd($tokenUser,$tokenUserTag);
        if ($tokenUser != false && $tokenUserTag != false) {
            $dis_user = $tokenUser->createRequest('GET', '/me')
            ->setReturnType(Model\User::class)
            ->execute();

            //$ms_user = json_decode(json_encode($dis_user), true);

            $dis_app = $tokenUserTag->createRequest('GET', '/me')
                ->setReturnType(Model\User::class)
                ->execute();
                $ms_tag = json_decode(json_encode($dis_app), true);
                //$ms_tag['displayName']
                $dataArray = [
                    "body" => [
                        "contentType" => "html",
                        "content" => "<at id='0'>" . $event->nameTag  . "</at> " . $event->dataArray
                    ],
                    "mentions" => [
                        [
                            "id" => 0,
                            "mentionText" => $event->nameTag,
                            "mentioned" => [
                                "user" => [
                                    "displayName" => $ms_tag['displayName'],
                                    "id" => $ms_tag['id'],
                                    "userIdentityType" => "aadUser"
                                ]
                            ]
                        ]
                    ]
                ];
            //ข้อมูล tag
            $ms_tag = json_decode(json_encode($dis_app), true);

            if($event->statusPost == "replies"){
                try{

                    $post_ms = $tokenUser->createRequest('POST', '/teams/'.$event->group_id.'/channels/'.$event->teams_chanel.'/messages/'.$event->Msteams_Id.'/replies')
                        ->attachBody($dataArray)
                        ->setReturnType(Model\User::class)
                        ->execute();
                    $postdown = "success";
                }catch (\Exception $e) {
                    $postdown = $e->getMessage();

                }
            }elseif($event->statusPost == "post"){

                try{
                    $post_ms = $tokenUser->createRequest('POST', '/teams/' . $event->group_id . '/channels/' .$event->teams_chanel . '/messages')
                    ->attachBody($dataArray)
                    ->setReturnType(Model\User::class)
                    ->execute();
                    $dataPost = json_decode(json_encode($post_ms), true);
                    $id_teams =   $dataPost['id'];  //id post เก็บลงฐาน
                    if($event->type_team=='contracts'){
                        $data = Pact_Contracts::where('id',$event->PactCon_id)->first();
                        $data->Msteams_Id = $id_teams;
                        $data->update();
                    }elseif($event->type_team=='audit'){
                        $audit = Pact_AuditTags::where('id',$event->PactCon_id)->first();
                        $audit->team_id = $id_teams;
                        $audit->update();
                    }

                }catch (\Exception $e) {
                    $postdown = $e->getMessage();

                }
            }
        }

    }
}
