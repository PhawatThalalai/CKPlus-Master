<?php

namespace App\Services;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\Event\MessageEvent\TextMessage;


class LineMessagingService
{

    protected $bot;

    // public function __construct()
    // {
    //     $httpClient = new CurlHTTPClient(env('LINE_CHANNEL_ACCESS_TOKEN'));
    //     $this->bot = new LINEBot($httpClient, ['channelSecret' => env('LINE_CHANNEL_SECRET')]);
    // }

    public function pushMessage($userId, $message)
    {
        $CHANNEL_ACCESS_TOKEN = 'vDpFSBM5+KafO6HB370IWmi0W1f5KSVKEghAPrhmWxddin3l81Wj/EQt+e0KkneJDFyoCdwwRtzCiGB0WIqEufxUo/FAXk7afcM6ssWwOi8lwit5poHWbiZLBBbgVUi913caKJEaXGSNd6vVXOggRwdB04t89/1O/w1cDnyilFU=';

        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($CHANNEL_ACCESS_TOKEN);
        $httpClient = new CurlHTTPClient($CHANNEL_ACCESS_TOKEN);

        // $textMessageBuilder = new TextMessageBuilder($message);
        // $response = $this->bot->pushMessage($userId, $textMessageBuilder);

        // return $response->isSucceeded();
    }
}
