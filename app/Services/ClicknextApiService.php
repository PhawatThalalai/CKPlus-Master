<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Str;

class ClicknextApiService
{
    protected $client;

    protected $Api_key = 'nS0q8v0gc4dkZzzBDhQFz5tQex3Vv1LhP8UY4Q2krvi4MB1wDDHijGBRz8qVWDuAArexa6RhWBnMA6cQGzD69qUfv9FWHA0vQphcc9j0YUpHQkxEzPwDxBqX33iwTgMK';


    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://chookiatl-mobile.ckl.co.th',
            // 'timeout' => 10.0,
        ]);
    }

    // public function sendData2()
    // {
    //     try {
    //         $data = [
    //             'accountId' => '7f5efd0c32097424912cbd4f123020b6f089421f0cb6f00c0ff08eed',
    //             'customerId' => '795de30d3e3bb153ebaae244d1a030f3bfa392cd26',
    //             'title' => 'afd573debf8ea7b33bfc35f15c3100a3f96e9e01fc021df8ca42e154dcd45d54abd8212e4c268595526b974911f4a65cdca8410c9736e2',
    //             'message' => 'afd54adebf9ca7b315fc35d25c303ea3f97c9e01db021cf8ca43fd54ddef5d548fd821384c268b0853639249fc0371ecbd672238b651d16727122027991b085a1318ce9159541fd0a8dd26590aea7e5fabf9ae33970084b81ba50a4774c233c324436cd652740b2f53b57949fdfd9f245e0310257b6437a3646d83890db4957353cea65b72bbd1c50bbbbd7274cdb37409d8d73dbdc9a0fccb77ca12f91252eb218c0c46d113333cedcd'
    //         ];

    //         $response = $this->client->post('/sendNotification', [
    //             'headers' => [
    //                 'Content-Type' => 'application/json',
    //                 'X-API-Key' => $this->Api_key,
    //                 'r1' => 'c6df2966f1d8d28c'
    //             ],
    //             'json' => $data
    //         ]);

    //         return json_decode($response->getBody(), true);
    //     } catch (RequestException $e) {
    //         return $this->handleException($e);
    //     }
    // }


    public function sendData(array $data, $R1, $_url)
    {
        try {
            $response = $this->client->post($_url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-API-Key' => $this->Api_key,
                    'r1' => $R1
                ],
                'json' => $data
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $this->handleException($e);
        }
    }

    public function getR2()
    {
        try {
            $R1 = $this->generateR1();
            $response = $this->client->post('/r2/get', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-API-Key' => $this->Api_key,
                    'r1' => $R1
                ]
            ]);

            $responseBody = json_decode($response->getBody(), true);
            if (isset($responseBody['data']['r2'])) {
                return [
                    'r1' => $R1,
                    'r2' => $responseBody['data']['r2']
                ];
            }

            return [
                'r1' => $R1,
                'response' => $responseBody
            ];
        } catch (RequestException $e) {
            return $this->handleException($e);
        }
    }

    public static function generateR1()
    {
        $randomUuidString = strtoupper(str_replace('-', '', Str::uuid()->toString()));
        $hashedResult = hash('sha256', $randomUuidString, false);

        return substr($hashedResult, 0, 16);
    }

    private function handleException(RequestException $e)
    {
        if ($e->hasResponse()) {
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);
        } else {
            $error = $e->getMessage();
        }

        return ['error' => $error];
    }
}
