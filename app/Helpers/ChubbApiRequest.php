<?php
use App\Events\frontend\LogDataContract;
use App\Models\TB_PactContracts\Data_PAResponse;
use App\Models\TB_PactContracts\Pact_Contracts;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class ChubbApiRequest
{
    public $domain = 'https://apacuat.chubbdigital.com';
    public $baseUrl = 'sales.microsite';
    public $Identity = 'ADB2C';
    public $Api_id = '48ea1746-432a-42f7-ad2b-6ab231d61596';
    public $Api_key = 'OZ48Q~wQP~LnNoRiC7e5KWXMOvw8e_xSsHk~Ka_8';
    public $authorizations = '1197-K3RDX4zcniv04+y6Fq2Toqmt6hpqy4Z+FuMd7XmXGzw=';
    public $Resource = '47f730fd-522f-4ac8-92ed-6a237000ee31 ';
    public $api_version = 1;
    public $subscription = '8b2c8948544e4d8199af1191ff0980e3';
    public $companyCode = '502040472';
    public $ContractNumber = 'PSXXQ860385';
    public $InsureIDCardNo = 'CNFIX802841217350';

    public function getToken()
    {

        $client = new Client([
            'base_uri' => $this->domain,
            //'verify' => base_path('cacert.pem'),
        ]);

        $response = $client->post("/enterprise.operations.authorization/?Identity=$this->Identity", [
            'headers' => [
                'App_ID' => $this->Api_id,
                'App_Key' => $this->Api_key,
                'Resource' => $this->Resource,
                'apiVersion' => $this->api_version
            ]
        ]);

        if ($response->getStatusCode() === 200) {

            $data = json_decode($response->getBody(), true);

            session()->put('AuthToken', $data['access_token']);

            return response()->json($data);
        } else {
            return response()->json(['err' => $response]);
        }
    }

    public function GetPaPackage($agentCode, $timeRack, $planId)
    {

        $authToken = session()->get('AuthToken');

        $client = new Client([
            'base_uri' => $this->domain,
            //'verify' => base_path('cacert.pem'),
        ]);

        $response = $client->get("$this->baseUrl/PA/packages?CompanyCode=$agentCode&CoverYear=$timeRack&PlanID=$planId", [
            'headers' => [
                'authorization' => "Bearer $authToken",
                'X-Authorization' => $this->authorizations,
                'Ocp-Apim-Subscription-Key' => $this->subscription,
                'apiVersion' => $this->api_version
            ]
        ]);

        if ($response->getStatusCode() === 200) {
            $data = json_decode($response->getBody(), true);


            return $data['Results'];
        } else {
            return response()->json(['err' => $response]);
        }
    }

    public function verifyIssue($dataArr)
    {

        $authToken = session()->get('AuthToken');

        $client = new Client([
            'base_uri' => $this->domain,
            //'verify' => base_path('cacert.pem'),
        ]);

        $response = $client->post("$this->baseUrl/PA/issue/verify", [
            'headers' => [
                'authorization' => "Bearer $authToken",
                'X-Authorization' => $this->authorizations,
                'Ocp-Apim-Subscription-Key' => $this->subscription,
                'apiVersion' => $this->api_version,
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode($dataArr)
        ]);

        if ($response->getStatusCode() === 200) {
            $data = json_decode($response->getBody(), true);

            return $data;
        } else {
            return response()->json(['err' => $response]);
        }
    }


    public function Issue($dataArr, $data)
    {
        $authToken = session()->get('AuthToken');

        $client = new Client([
            'base_uri' => $this->domain,
            //  'verify' => base_path('cacert.pem'),
        ]);

        $response = $client->post("$this->baseUrl/PA/issue", [
            'body' => json_encode($dataArr),
            'headers' => [
                'authorization' => "Bearer $authToken",
                'X-Authorization' => $this->authorizations,
                'Ocp-Apim-Subscription-Key' => $this->subscription,
                'apiVersion' => $this->api_version,
                'Content-Type' => 'application/json',
            ],
        ]);


        if ($response->getStatusCode() === 200) {
            // dd($data->DataCus_id);
            $dataDecode = json_decode($response->getBody(), true);
            $dataPA = DB::table('Data_PAResponse')->where('DataPact_id', $data->id)->first();
            if ($dataPA == NULL) {
                $res = DB::table('Data_PAResponse')->insert([
                    'DataCus_id' => $data->DataCus_id,
                    'DataPact_id' => $data->id,
                    'ContractNumber' => $dataDecode['ContractNumber'],
                    'PolicyNumber' => $dataDecode['PolicyNumber'],
                    'NotificationNumber' => $dataDecode['NotificationNumber'],
                    'PolicyNumber2' => $dataDecode['PolicyNumber2'],
                    'NotificationNumber2' => $dataDecode['NotificationNumber2'],
                    'URLPrint' => $dataDecode['URLPrint'],
                    'URLPrintCopy' => $dataDecode['URLPrintCopy'],
                    'URLPrintCard' => $dataDecode['URLPrintCard'],
                    'URLPrintApp' => $dataDecode['URLPrintApp'],
                    'TransactionID' => $dataDecode['TransactionID'],
                    'TransactionResponseDt' => $dataDecode['TransactionResponseDt'],
                    'TransactionResponseTime' => $dataDecode['TransactionResponseTime'],
                    'MsgStatusCd' => $dataDecode['MsgStatusCd'],
                    'ErrorMessage' => $dataDecode['ErrorMessage'],
                    'TaxInvoiceNo' => $dataDecode['TaxInvoiceNo'],
                ]);
            }


            return true;
        } else {
            return response()->json(['err' => $response]);
        }
    }


    public static function sendAndGetPA($callAgent, $data)
    {
        //  dd( $callAgent['agentCode']  );
        $chubbApi = new ChubbApiRequest;
        $chubbApi->getToken();

        $Timelack = 0;
        $dataCusPA = DB::table('View_ReportPAData')->where('Status_Con', '<>', 'cancel')
            ->where('Contract_Con',$data->Contract_Con)->first();
          if(@$dataCusPA->Timelack_Car>84){
              $Timelack = round(84/12);
          }else{
              $Timelack =round(@$dataCusPA->Timelack_Car/12);
          }
          //$callAgent['agentCode']       
          $package = $chubbApi->GetPaPackage($callAgent,strval($Timelack),@$dataCusPA->PlanId);
          dd($callAgent,strval($Timelack),@$dataCusPA->PlanId,$package);
       // @$dataCusPA->Date_monetary
       $yearPA = '+'.($Timelack/12).' year';
        @$datemonetary = explode(' ',@$dataCusPA->Date_monetary);
        $paStop = date('Y-m-d', strtotime($yearPA,strtotime( $datemonetary[0])));

          $dataArr = [
            "CompanyCode" =>  $callAgent ,
            "PolicyStatus" => "N",
            "ContractNumber" => ($dataCusPA->Contract_Con),
            "CampaignCode" => $package[0]['CampaignCode'],
            "InsureType" => "P",
            "InsureTitleName" => $dataCusPA->Prefix,
            "InsureName" => $dataCusPA->Firstname_Cus,
            "InsureLastName" => $dataCusPA->Surname_Cus,
            "InsureIDCardNo" => ($dataCusPA->IDCard_cus),
            "InsureIDCardType" => "P1",
            "InsureDateOfBirth" => $dataCusPA->Birthday_cus,
            "InsureGender" => $dataCusPA->Detail_Sex == "ชาย" ? 'M' : 'F',
            "InsureOccupation" => null,
            "InsureAddress1" => $dataCusPA->houseNumber_Adds . " ม." . $dataCusPA->houseGroup_Adds,
            "InsureAddress2" => " ",
            "InsureSubDistrict" => $dataCusPA->houseTambon_Adds,
            "InsureDistrict" => $dataCusPA->houseDistrict_Adds,
            "InsureProvince" => $dataCusPA->houseProvince_Adds,
            "InsureZipcode" => $dataCusPA->Postal_Adds,
            "InsureTelMobile" => $dataCusPA->Phone_cus,
            "InsureEmail" => "",
            "BeneficiaryName" => $dataCusPA->Company_Name,
            "BeneficiaryRelation" => "เจ้าหนี้",
            "BeneficiaryTel" => null,
            "SaleDate" => $datemonetary[0],
            "SaleName" => null,
            "EffectiveDate" => $datemonetary[0],
            "ExpiryDate" => $paStop,
            "PackageCode" => $package[0]['PackageCode'],
            "GrossPremium" => $package[0]['Premium'],
            "Stamp" => @$package[0]['Stamp'],
            "SBT" => $package[0]['Vat'],
            "TotalPremium" => $package[0]['TotalPremium'],
            "InsurePassportNo" => null,
            "Language" => "T",
            "CampaignType" => $package[0]['CampaignType'],
            "IsRenew" => false,
            "PreviousPolicyNumber" => ""
        ];


        $checkValue = $chubbApi->verifyIssue($dataArr);

        if (@$checkValue['Status'] != NULL && @$checkValue['Status'] == 'true') {
            $txtLog = "ยื่นประกันสำเร็จ";
            $ResponseData = $chubbApi->Issue($dataArr, $data);
            $Pact = Pact_Contracts::find(@$dataCusPA->id_con);
            $Pact->Flag_PARespon == NULL;
            $Pact->update();
            event(new LogDataContract(@$dataCusPA->id_con, 'Alert', 'LogRejected-PA', 'Rejected-PA', $txtLog . " : " . $data->id, auth()->user()->id));
            return true;

        } else {
            $txtLog = implode(",", array_column(@$checkValue['Errors'], "Message"));

            event(new LogDataContract(@$dataCusPA->id_con, 'Alert', 'LogRejected-PA', 'Rejected-PA', $txtLog . " : " . $data->id, auth()->user()->id));
            $Pact = Pact_Contracts::find(@$dataCusPA->id_con);
            $Pact->Flag_PARespon == 'rejected';
            $Pact->update();
            return response(['error' => true, 'message' => @$checkValue['Errors']], 500);
        }



    }
}
