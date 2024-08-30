<?php // Code within app\Helpers\Helper.php
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use GuzzleHttp\Client;
use Symfony\Component\Mime\Message;
class ConnectMSTeams
{
    public static function getTokenUser($user,$password){
        try{
                $msTeams = auth()->user()->UserToMSTeams;
                $clientSecret = $msTeams->ClientSecret_Id ;
                $tenantId = $msTeams->Tenant_Id;
                $clientId = $msTeams->Client_Id;

                $guzzle = new Client();
                $url = 'https://login.microsoftonline.com/' . $tenantId . '/oauth2/v2.0/token';
                $token = json_decode($guzzle->post($url, [
                    'form_params' => [
                        'grant_type'    => 'password', // password
                        'client_id'     => $clientId,
                        'client_secret' => $clientSecret,
                        'scope'         => "https://graph.microsoft.com/.default",
                        'username'      => $user,
                        'password'      => $password,
                    ],
                ])->getBody()->getContents());
                $userlogin = new Graph();
                $userlogin->setAccessToken($token->access_token);
                return $userlogin;
            }catch (\Exception $e) {

                return false;

            }



    }

}
