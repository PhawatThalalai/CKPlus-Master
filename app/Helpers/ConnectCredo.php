<?php
use App\Events\frontend\LogDataCusTag;
use App\Models\api\TB_TokenApi;
use App\Models\TB_DataCus\Data_CusTags;
use GuzzleHttp\Client;// Code within app\Helpers\Helper.php

class ConnectCredo
{
    //ดึง token จากหน้าเว็บหลัง login
    // public static function postPage(){
    //     $headers = [
    //         "Content-Type: application/json",
    //         "Accept:application/json",
    //         "Cache-Control:no-cache"
    //     ];



    //     $curlx = curl_init($url);
    //     //$post = http_build_query($pvars);
    //     curl_setopt ($curlx, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5)));
    //     curl_setopt ($curlx, CURLOPT_HEADER, 0);
    //     curl_setopt ($curlx, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt ($curlx, CURLOPT_SSL_VERIFYPEER, 0);
    //     //curl_setopt($curlx, CURLOPT_VERBOSE, true);
    //     curl_setopt ($curlx, CURLOPT_POST, 1);
    //     curl_setopt($curlx,CURLOPT_POSTFIELDS, json_encode($pvars));
    //     //curl_setopt($curlx,CURLOPT_POSTFIELDS, ($post));
    //     //curl_setopt($curl, CURLOPT_USERPWD,  $auth);
    //     curl_setopt($curlx,CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($curlx, CURLOPT_AUTOREFERER, true);
    //     curl_setopt($curlx, CURLOPT_FOLLOWLOCATION,true); // follow redirects recursively
    //     curl_setopt($curlx, CURLOPT_FOLLOWLOCATION,false); // follow redirects recursively
    //     //curl_setopt($curlx, CURLOPT_FILE, $fp);

    //     if(curl_exec($curlx) === false){
    //         echo 'Curl error: ' . curl_error($curlx);
    //     }else{
    //         $contents=curl_exec($curlx);
    //     }
    //     curl_close($curlx);
    //     // dd($contents);

    //     return $contents;
    // }

    public static function postCreate($url, $pvars, $token)
    {
        dd('test');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt ($ch, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5)));
        //curl_setopt ($ch, CURLOPT_HEADER, 0);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // Returns the data/output as a string instead of raw data

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($pvars));
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json-patch+json',
                'Accept:application/json',
                'Authorization: Bearer ' . $token
            )
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    public static function postScore($value)
    {
        $tokendata = TB_TokenApi::where('token_name', 'credo_api')->first();
        $url = "https://scoring.credolab.com/v6.0/datasets/$value/datasetinsight";
        // $dataToken = ConnectCredo::postPage();
        // $dataKeyToken= json_decode($dataToken,true);
        //$dataKeyToken["access_token"];
        $token = base64_decode($tokendata->token_id);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0", rand(4, 5)));
        //curl_setopt ($ch, CURLOPT_HEADER, 0);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // Returns the data/output as a string instead of raw data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 0);
        //Set your auth headers
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Accept:application/json',
                'Authorization: Bearer ' . $token
            )
        );
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        $data = curl_exec($ch);

        // get info about the request
        $info = curl_getinfo($ch);
        // close curl resource to free up system resources
        curl_close($ch);
        $dataSet["data"] = $data;
        $dataSet["info"] = $info;
        $data1 = json_decode($dataSet["data"], true);

        if ($info['http_code'] == 200) {
            $GetScore = (isset($data1['scores']) ? $data1['scores'][0]['value'] : 0);
            $statusCode = 200;

            $deviceIds = array_column(array_filter($data1['fragments'], function ($fragment) {
                return $fragment['code'] === 'device';
            }), 'value', 'code');
        } else {
            $GetScore = 0;
            $statusCode = $info['http_code'];
        }

        $deviceId = isset($deviceIds['device']['deviceId']) ? $deviceIds['device']['deviceId'] : null;
        return array('GetScore' => $GetScore, 'statusCode' => $statusCode, 'data' => $data1, 'deviceId' => $deviceId);

    }
    public static function getTokenUser($user, $password)
    {
        $msTeams = auth()->user()->UserToMSTeams;
        $clientSecret = $msTeams->ClientSecret_Id;
        $tenantId = $msTeams->Tenant_Id;
        $clientId = $msTeams->Client_Id;
        $teams_chanel = $msTeams->Teams_Chanel;
        $group_id = $msTeams->Group_Id;

        try {
            $guzzle = new \GuzzleHttp\Client();
            $url = 'https://login.microsoftonline.com/' . $tenantId . '/oauth2/v2.0/token';
            $token = json_decode($guzzle->post($url, [
                'form_params' => [
                    'grant_type' => 'password', // password
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'scope' => "https://graph.microsoft.com/.default",
                    'username' => $user,
                    'password' => $password,
                ],
            ])->getBody()->getContents());

            return $token;

        } catch (\Exception $e) {
            return false;

        }
    }
    public static function getMI($dataArr)
    {
        try {


            $url = 'http://192.168.89.1:8000/predict';


            $client = new Client([
                'headers' => ['Content-Type' => 'application/json']
            ]);

            $response = $client->post(
                $url,
                ['body' => $dataArr]
            );

            return $response->getBody()->getContents();

        } catch (\Exception $e) {

            return $e->getMessage();

        }
    }
    public static function getDataMI($id)
    {

        $dataMiView = DB::table('View_MIDATA')->where('id', $id)->first();
        $countNull = 0;
        if ($dataMiView != NULL) {
            $dataArray = json_decode(json_encode($dataMiView), true);
            $filteredData = array_filter($dataArray, 'is_null');
            $countNull = count($filteredData);

            if (@$dataMiView->id_rateType == 'car' || @$dataMiView->id_rateType == 'moto') {
                if ($countNull < 3) {
                    $dataMI = array(
                        'applied_date' => @$dataMiView->applied_date,
                        'zone' => @$dataMiView->zone,
                        'customer_type' => @$dataMiView->customer_type,
                        'loan_type' => @$dataMiView->loan_type,
                        'contract_no' => @$dataMiView->contract_no,
                        'credo_score' => floatval(@$dataMiView->Credo_Score), //int
                        'gender' => @$dataMiView->gender,
                        'birth_date' => @$dataMiView->birth_date,
                        'age' => floatval(@$dataMiView->age),//int
                        'occupation' => @$dataMiView->occupation,
                        'occupation2' => NULL,
                        'status' => @$dataMiView->status,
                        'vehicle_brand' => @$dataMiView->vehicle_brand,
                        'vehicle_model' => @$dataMiView->vehicle_model,
                        'vehicle_launched_year' => floatval(@$dataMiView->vehicle_launched_year),//int
                        'vehicle_acquired_date' => @$dataMiView->vehicle_acquired_date,
                        'vehicle_acquired_num_days' => floatval(@$dataMiView->vehicle_acquired_num_days),//int
                        'vehicle_acquired_order' => @$dataMiView->vehicle_acquired_order,
                        'vehicle_book_p16' => @$dataMiView->vehicle_book_p16,
                        'vehicle_book_p18' => @$dataMiView->vehicle_book_p18,
                        'vehicle_estimated_price' => floatval(@$dataMiView->vehicle_estimated_price),//int
                        'loan_amount' => floatval(@$dataMiView->loan_amount),//int
                        'ltv' => @$dataMiView->ltv != 0 ? floatval(@$dataMiView->ltv) : NULL,//int
                        'interest_rate' => floatval(@$dataMiView->interest_rate),//int
                        'num_installment' => floatval(@$dataMiView->num_installment),//int
                        'installment_amount' => floatval(@$dataMiView->installment_amount)
                    );//int
                    $dataArr = json_encode($dataMI);

                    $getDataMI = ConnectCredo::getMI($dataArr);
                    $deCodeMi = json_decode(@$getDataMI);

                    return $deCodeMi;// response()->json([  'data' =>  $deCodeMi] );
                }
            }
        }


    }

}
