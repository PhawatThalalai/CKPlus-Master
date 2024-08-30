<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Encryption\Encrypter;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Carbon\Carbon;

use App\Models\api\user_api;
use App\Models\api\TB_ConfigverifyR2;

use App\Models\TB_DataCus\Data_Customers;
use App\Models\TB_DataCus\Data_CusTags;

use App\Models\TB_Logs\Data_CredoFragments;
use App\Models\TB_Logs\Data_CredoCodes;

use App\Traits\JsonResources;
use App\Traits\OTPRequests;
use App\Traits\NumberingRequests;

use ConnectCredo;

use App\Http\Resources\CustomerResources;
use App\Models\Sanctum\PersonalAccessToken;

class AccountController extends Controller
{
    use JsonResources, OTPRequests, NumberingRequests;

    // public function login()
    // {
    //     $credentials = request()->only(['CardID','Phone']);

    //     if (!($credentials)) {
    //         return response()->json(['Code' => 90000, 'Message' => 'ขออภัย ระบบเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง']);
    //     } else {
    //         $user = Data_Customers::where('IDCard_cus', $credentials['CardID'])
    //             ->where('Phone_cus', $credentials['Phone'])
    //             ->first();

    //         if ($user) {
    //             DB::transaction(function () use ($user) {
    //                 $user->update([
    //                     'status' => '1',
    //                 ]);
    //             });
    //             $user_api = user_api::findOrCreate(['data_customer_id' => $user->id]);
    //             $user_api->first_name = 'John';
    //             $user_api->last_name = 'Doe';
    //             $user_api->save();


    //             $user->tokens()->delete();
    //             $token = $user->createToken('token')->plainTextToken;


    //             return response()->json(['Code' => 00000, 'token' => $token, 'user' => $user]);
    //         }
    //         else {
    //             return response()->json(['Code' => 20001, 'Message' => 'หมายเลขบัตรประชาชนหรือหมายเลขโทรศัพท์ไม่ถูกต้อง']);
    //         }
    //     }
    // }

    // public function login()
    // {
    //     $credentials = request()->only(['CardID', 'Phone']);

    //     if (!($credentials)) {
    //         return response()->json(['Code' => 20001, 'Message' => 'หมายเลขบัตรประชาชนหรือหมายเลขโทรศัพท์ไม่ถูกต้อง']);
    //     } else {

    //         try {
    //             DB::transaction(function () use ($credentials) {
    //                 $user = Data_Customers::where('IDCard_cus', $credentials['CardID'])
    //                     ->where('Phone_cus', $credentials['Phone'])
    //                     ->first();

    //                 if ($user) {
    //                     $user_api = user_api::findOrCreate(['data_customer_id' => $user->id]);
    //                     $user_api->data_customer_id = $user->id;
    //                     $user_api->token = 'token';
    //                     $user_api->save();

    //                     $user->tokens()->delete();
    //                     $token = $user->createToken('token')->plainTextToken;

    //                     return response()->json(['Code' => 00000, 'token' => $token, 'user' => $user]);
    //                 } else {
    //                     return response()->json(['Code' => 20001, 'Message' => 'ไม่พบข้อมูลที่ต้องการเรียก']);
    //                 }
    //             });
    //         } catch (\Exception $e) {
    //             return response()->json(['Code' => 90000, 'Message' => 'ขออภัย ระบบเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง']);
    //         }
    //     }
    // }

    public function accountverify()
    {
        // $data = [
        //     'accountId' => '03-2563/0004',
        //     'customerId' => '60339',
        //     'title' => 'รับชำระค่างวด',
        //     'message' => 'บริษํัทได้รับชำระค่างวดลูกค้าเรียบร้อยแล้ว ขอบคุณค่ะ',
        // ];

        // $r1 = 'c6df2966f1d8d28c';
        // $r2 = '38f9612fdf344a95';

        // $test = encryptredVariable($data, $r1, $r2);
        // dd($test);

        $credentials = request()->only(['IdentityNumber', 'phoneNumber']);
        if (in_array(null, $credentials, true)) {
            $responseStatus = $this->formatJsonData('20001', 'accountVerify', '', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }

        $R1 = request()->header('r1');
        $R2 = TB_ConfigverifyR2::where('code_r1', $R1)->value('code_r2');
        if (!$R2) {
            $responseStatus = $this->formatJsonData('30001', 'accountVerify', 'Data not found with R2', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }

        $decrypted = decryptedVariable($credentials, $R1, $R2);
        if ($decrypted === false) {
            $responseStatus = $this->formatJsonData('20001', 'accountVerify', 'Error decrypting variable', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }

        try {
            $response = null;
            DB::transaction(function () use ($decrypted, &$response) {
                $user = Data_Customers::where('Flag_Con', 'Y')
                    ->where('IDCard_cus', $decrypted['IdentityNumber'])
                    ->where('Phone_cus', $decrypted['phoneNumber'])
                    ->first();

                if ($user) {
                    $responseStatus = $this->formatJsonData('00000', 'accountVerify', '', '', 'SUCCESS');
                    $response = response()->json(['responseStatus' => $responseStatus, 'data' => null], 200);
                } else {
                    $responseStatus = $this->formatJsonData('30001', 'accountVerify', 'ไม่พบข้อมูลลูกค้าในระบบ กรุณาลองใหม่อีกครั้ง', 'Popup', 'ERROR');
                    $response = response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
                }
            });

            return $response;
        } catch (\Exception $e) {
            $responseStatus = $this->formatJsonData('90000', 'accountVerify', 'ขออภัย ระบบเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }
    }

    public function updateToken()
    {
        $credentials = request()->only(['customerId', 'deviceId', 'deviceName']);
        if (in_array(null, $credentials, true)) {
            $responseStatus = $this->formatJsonData('20001', 'updateToken', '', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }

        $R1 = request()->header('r1');
        $R2 = TB_ConfigverifyR2::where('code_r1', $R1)->value('code_r2');
        if (!$R2) {
            $responseStatus = $this->formatJsonData('30001', 'accountVerify', 'Data not found with R2', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }

        // $decrypted = decryptedVariable($credentials, $R1, $R2);
        // if (in_array(null, $credentials, true)) {
        //     $responseStatus = $this->formatJson('20001', 'updateToken', '', 'Popup', 'ERROR');
        //     return response()->json(['responseStatus' => $responseStatus, 'data' => null]);
        // }
        try {
            $response = null;
            DB::transaction(function () use ($credentials, &$response, &$R1, &$R2) {
                $id = decryptedVariable($credentials['customerId'], $R1, $R2);
                $user = Data_Customers::find($id);
                if ($user) {
                    // generate token and insert to database user_api
                    $user_api = user_api::updateOrCreate(
                        [
                            'data_customer_id' => $user->id,
                        ],
                        [
                            'device_id' => $credentials['deviceId'],
                            'device_name' => $credentials['deviceName'],
                            'token' => request()->header('updateToken'),
                            'platform' => 'CN',
                            'platform_version' => '1.0.0',
                            'app_version' => '1.0.0',
                        ]
                    );

                    // $user->tokens()->delete();
                    // $token = $user->createToken('CN', ['*'], now()->addHours(8));
                    $responseStatus = $this->formatJsonData('00000', 'updateToken', '', '', 'SUCCESS');
                    $response = response()->json(['responseStatus' => $responseStatus, 'data' => null], 200);
                } else {
                    $responseStatus = $this->formatJsonData('30001', 'updateToken', 'ไม่พบข้อมูลที่ต้องการเรียก', 'Popup', 'ERROR');
                    $response = response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
                }

                DB::commit();
            });

            return $response;
        } catch (\Exception $e) {
            DB::rollBack();

            $responseStatus = $this->formatJsonData('90000', 'updateToken', 'ขออภัย ระบบเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }
    }

    public function loginuser()
    {
        $credentials = request()->only(['IdentityNumber', 'phoneNumber']);
        if (in_array(null, $credentials, true)) {
            $responseStatus = $this->formatJsonData('20001', 'loginUser', '', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }

        $R1 = request()->header('r1');
        $R2 = TB_ConfigverifyR2::where('code_r1', $R1)->value('code_r2');
        if (!$R2) {
            $responseStatus = $this->formatJsonData('30001', 'loginUser', 'Data not found with R2', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }

        $decrypted = decryptedVariable($credentials, $R1, $R2);
        if ($decrypted === false) {
            $responseStatus = $this->formatJsonData('20001', 'loginUser', 'Error decrypting variable', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }

        try {
            $response = null;
            DB::transaction(function () use ($decrypted, &$response, &$R1, &$R2) {
                $user = Data_Customers::where('Flag_Con', 'Y')
                    ->where('IDCard_cus', $decrypted['IdentityNumber'])
                    ->where('Phone_cus', $decrypted['phoneNumber'])
                    ->first();

                if ($user) {
                    // if ($user) {
                    // $user->tokens()->delete();
                    // $token = $user->createToken('CN');
                    // $token = $user->createToken('CN', ['*'], now()->addHours(8));

                    $response = response()->json([
                        'responseStatus' => $this->formatJsonData('00000', 'loginUser', '', '', 'SUCCESS'),
                        'data' => new CustomerResources($user, $R1, $R2)
                    ], 200);
                } else {
                    $responseStatus = $this->formatJsonData('30001', 'loginUser', 'ไม่พบข้อมูลที่ต้องการเรียก', 'Popup', 'ERROR');
                    $response = response()->json(['responseStatus' => $responseStatus, 'data' => [null]], 400);
                }
            });

            return $response;
        } catch (\Exception $e) {
            $responseStatus = $this->formatJsonData('90000', 'loginUser', 'ขออภัย ระบบเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }
    }

    public function GetReference2()
    {
        $R1 = request()->input('r1');
        $randomUuidString = strtoupper(str_replace('-', '', Str::uuid()->toString()));

        $hashedResult = (hash('sha256', $randomUuidString, false));
        $R2 = substr($hashedResult, 0, 16);

        if ($R2) {
            $response = null;
            try {
                DB::transaction(function () use ($R1, $R2, &$response) {
                    $configVerifyR2 = TB_ConfigverifyR2::create([
                        'code_r1' => $R1,
                        'code_r2' => $R2,
                    ]);

                    if ($configVerifyR2) {
                        $responseStatus = $this->formatJsonData('00000', 'getR2', '', '', 'SUCCESS');
                        $data['r2'] = $R2;
                    } else {
                        $responseStatus = $this->formatJsonData('90000', 'getR2', 'ขออภัย ระบบเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'Popup', 'ERROR');
                        $data[] = null;
                    }

                    $response = response()->json(['responseStatus' => $responseStatus, 'data' => $data]);
                    DB::commit();
                });

                return $response;
            } catch (\Exception $e) {
                DB::rollBack();

                $responseStatus = $this->formatJsonData('90000', 'getR2', 'ขออภัย ระบบเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'Popup', 'ERROR');
                return response()->json(['responseStatus' => $responseStatus, 'data' => null]);
            }
        }
    }

    public function getCredocode()
    {
        $R1 = request()->header('r1');
        $R2 = TB_ConfigverifyR2::where('code_r1', $R1)->value('code_r2');

        if (!$R2) {
            $responseStatus = $this->formatJsonData('30001', 'getCredocode', 'Data not found with R2', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }

        $credentials = request()->only(['prefix', 'firstname', 'lastname', 'phoneNumber', 'branchId', 'deviceId', 'deviceName']);
        if (in_array(null, $credentials, true)) {
            $responseStatus = $this->formatJsonData('20001', 'getCredocode', 'Data not found', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }

        // เลือกเฉพาะคีย์ที่ต้องการ
        $selectedKeys = ['branchId', 'deviceId', 'deviceName'];
        $selectedCredentials = array_diff_key($credentials, array_flip($selectedKeys));

        $decryptedCredentials = array_map(function ($value) use ($R1, $R2) {
            return decryptedVariable($value, $R1, $R2);
        }, $selectedCredentials);

        if (in_array(false, $decryptedCredentials, true)) {
            $responseStatus = $this->formatJsonData('20004', 'getCredocode', 'longinToken is invalid', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }

        $credoCode = Data_CredoCodes::where('device_id', $credentials['deviceId'])
            ->with([
                'credoCustag' => function ($query) {
                    $query->whereNotIn('Status_Tag', ['inactive'])
                        ->with([
                            'TagToContracts' => function ($query) {
                                $query->whereNotIn('Status_Con', ['cancel']);
                            }
                        ]);
                }
            ])
            ->latest('id')->first();

        // device_id is empry on credo_codes table
        if (!isset($credoCode)) {
            $datacus = Data_Customers::where('Phone_cus', $decryptedCredentials['phoneNumber'])
                ->with([
                    'CusToCusTagOne' => function ($query) {
                        $query->whereNotIn('Status_Tag', ['inactive']);
                    }
                ])
                ->first();

            if ($datacus) {
                $tagDescription = $updateTag = null;

                if (isset($datacus->CusToCusTagOne)) {
                    if ($datacus->CusToCusTagOne->Status_Tag == 'complete' && isset($datacus->CusToCusTagOne->TagToContracts)) {
                        $Pact_cont = $datacus->CusToCusTagOne->TagToContracts;
                        $daysDifference = now()->diffInDays(Carbon::parse($Pact_cont->Date_monetary));

                        // ตรวจสอบว่าไม่เกิน 60 วัน
                        $tagDescription = ($daysDifference <= 60) ? 'สร้าง credoCode ต่ำกว่า 60 วัน' : null;
                    } else {
                        $updateTag = true;
                    }
                }

                // create new credo code
                $runCredoCode = $this->runCredoCode($datacus->id, $decryptedCredentials['phoneNumber'], $credentials['deviceId'], $credentials['deviceName'], 'mobile CN', $tagDescription);
                if (!isset($runCredoCode)) {
                    $responseStatus = $this->formatJsonData('90000', 'getCredocode', 'ขออภัย ระบบเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'Popup', 'ERROR');
                    return response()->json(['responseStatus' => $responseStatus, 'data' => null]);
                }

                if ($updateTag) {
                    try {
                        DB::transaction(function () use ($datacus, $runCredoCode, &$response) {
                            $datacus->CusToCusTagOne->update([
                                'Credo_Code' => $runCredoCode,
                                'Credo_Score' => null,
                                'Credo_Status' => null,
                                'Credo_Date' => null
                            ]);

                            $responseStatus = $this->formatJsonData('00000', 'getCredocode', '', '', 'SUCCESS');
                            $response = response()->json(['responseStatus' => $responseStatus, 'data' => ['credo_code' => $runCredoCode]]);

                            DB::commit();
                        });
                        return $response;
                    } catch (\Throwable $th) {
                        DB::rollBack();

                        $responseStatus = $this->formatJsonData('90000', 'getCredocode', 'ขออภัย ระบบเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'Popup', 'ERROR');
                        return response()->json(['responseStatus' => $responseStatus, 'data' => null]);
                    }
                } else {
                    $responseStatus = $this->formatJsonData('00000', 'getCredocode', '', '', 'SUCCESS');
                    return response()->json(['responseStatus' => $responseStatus, 'data' => ['credo_code' => $runCredoCode]]);
                }
            } else {
                // สร้างข้อมูลลูกค้าใหม่
                $zone = DB::table('TB_Branchs')->where('id', $credentials['branchId'])->value('Zone_Branch');
                try {
                    DB::transaction(function () use ($decryptedCredentials, $credentials, $zone, &$response) {
                        $newcus = Data_Customers::create([
                            'Status_Cus' => 'active',
                            'type_Cus' => 'api',
                            'date_Cus' => date('Y-m-d'),
                            'Prefix' => @$decryptedCredentials['prefix'],
                            'Name_Cus' => $decryptedCredentials['firstname'] . ' ' . $decryptedCredentials['lastname'],
                            'Firstname_Cus' => $decryptedCredentials['firstname'],
                            'Surname_Cus' => $decryptedCredentials['lastname'],
                            'Phone_cus' => $decryptedCredentials['phoneNumber'],
                            'UserZone' => $zone,
                            'UserBranch' => $credentials['branchId'],
                            'UserInsert' => 'mobile CN',
                        ]);

                        // create new credo code
                        $runCredoCode = $this->runCredoCode($newcus->id, $decryptedCredentials['phoneNumber'], $credentials['deviceId'], $credentials['deviceName'], 'mobile CN', null);
                        if (!isset($runCredoCode)) {
                            $responseStatus = $this->formatJsonData('90000', 'getCredocode', 'ขออภัย ระบบเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'Popup', 'ERROR');
                        } else {
                            $responseStatus = $this->formatJsonData('00000', 'getCredocode', '', '', 'SUCCESS');
                        }
                        $response = response()->json(['responseStatus' => $responseStatus, 'data' => ['credo_code' => $runCredoCode]]);

                        DB::commit();
                    });

                    return $response;
                } catch (\Exception $e) {
                    DB::rollBack();

                    $responseStatus = $this->formatJsonData('90000', 'getCredocode', 'ขออภัย ระบบเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'Popup', 'ERROR');
                    return response()->json(['responseStatus' => $responseStatus, 'data' => null]);
                }
            }
        } else {
            if ($credoCode->credo_flag == 'Y' && $credoCode->statusActive == 'Y') {
                $tagDescription = null;

                if ($credoCode->credoCustag->Status_Tag == 'complete' && isset($credoCode->credoCustag->TagToContracts)) {
                    $Pact_cont = $credoCode->credoCustag->TagToContracts;
                    $daysDifference = now()->diffInDays(Carbon::parse($Pact_cont->Date_monetary));

                    // ตรวจสอบว่าไม่เกิน 60 วัน
                    $tagDescription = ($daysDifference <= 60) ? 'สร้าง credoCode ต่ำกว่า 60 วัน' : null;
                } else {
                    $responseStatus = $this->formatJsonData('90000', 'getCredocode', 'ลูกค้าได้ลงทะเบียนเรียบร้อยแล้ว โปรดรอเจ้าหน้าที่ดำเนินการ', 'Popup', 'ERROR');
                    return response()->json(['responseStatus' => $responseStatus, 'data' => ['credo_code' => null]]);
                }

                // create new credo code
                $runCredoCode = $this->runCredoCode($credoCode->data_customer_id, $decryptedCredentials['phoneNumber'], $credentials['deviceId'], $credentials['deviceName'], 'mobile CN', $tagDescription);
                if (!isset($runCredoCode)) {
                    $responseStatus = $this->formatJsonData('90000', 'getCredocode', 'ขออภัย ระบบเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'Popup', 'ERROR');
                } else {
                    $responseStatus = $this->formatJsonData('00000', 'getCredocode', '', '', 'SUCCESS');
                }
                return response()->json(['responseStatus' => $responseStatus, 'data' => ['credo_code' => $runCredoCode]]);

            } else {
                $responseStatus = $this->formatJsonData('00000', 'getCredocode', '', '', 'SUCCESS');
                return response()->json(['responseStatus' => $responseStatus, 'data' => ['credo_code' => $credoCode->credo_code]]);

                // $responseStatus = $this->formatJsonData('90000', 'getCredocode', 'ลูกค้าได้ลงทะเบียนเรียบร้อยแล้ว โปรดรอเจ้าหน้าที่ดำเนินการ', 'Popup', 'ERROR');
                // return response()->json(['responseStatus' => $responseStatus, 'data' => ['credo_code' => null]]);
            }
        }
    }

    public function updateCredo()
    {
        $credentials = request()->only(['credoCode']);
        if (in_array(null, $credentials, true)) {
            $responseStatus = $this->formatJsonData('20001', 'updateCredo', 'Data not found', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }
        $dataCredo = Data_CredoCodes::where('credo_code', $credentials['credoCode'])->where('credo_flag', 'N')->first();
        if ($dataCredo) {
            $Score = ConnectCredo::postScore($credentials['credoCode']);
            try {
                DB::transaction(function () use ($dataCredo, $Score, $credentials, &$response) {
                    if ($Score['statusCode'] == 200) {
                        $chk_inLog = Data_CredoFragments::where('referenceNumber', $credentials['credoCode'])->first();
                        if (empty($chk_inLog)) {
                            $fragments = $Score['data']['fragments'];

                            $data_Fragment = new Data_CredoFragments;
                            $data_Fragment->referenceNumber = @$Score['data']['datasetInfo']['referenceNumber'];
                            $data_Fragment->uploadDate = @$Score['data']['datasetInfo']['uploadDate'];
                            $data_Fragment->device_id = @$Score['deviceId'];
                            $data_Fragment->scores = ($Score['GetScore'] != 0) ? json_encode($Score['data']['scores']) : 0;
                            for ($i = 0; $i < 10; $i++) {
                                $data_Fragment->{'fragments' . ($i + 1)} = (isset($fragments[$i])) ? json_encode($fragments[$i]) : null;
                            }

                            $data_Fragment->save();
                        }

                        $dataCredo->update([
                            'credo_flag' => 'Y',
                            'credo_date' => date('Y-m-d H:i:s'),
                            'credo_score' => @$Score['data']['scores'][1]['value'],
                            'credo_score2' => @$Score['data']['scores'][0]['value'],
                            'credo_status' => 'CD-0005',
                        ]);
                    }

                    $responseStatus = $this->formatJsonData('00000', 'getCredocode', '', '', 'SUCCESS');
                    $response = response()->json(['responseStatus' => $responseStatus, 'data' => null]);

                    DB::commit();
                });

                return $response;
            } catch (\Exception $e) {
                DB::rollBack();

                $responseStatus = $this->formatJsonData('90000', 'updateCredo', 'ขออภัย ระบบเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'Popup', 'ERROR');
                return response()->json(['responseStatus' => $responseStatus, 'data' => null]);
            }
        } else {
            $responseStatus = $this->formatJsonData('30001', 'updateCredo', 'ไม่พบข้อมูลที่ต้องการเรียก', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }
    }

    public function requestOTP()
    {
        $credentials = request()->only(['phoneNumber']);
        $otpJson = $this->sendOTP($credentials['phoneNumber']);
        $otpArray = json_decode($otpJson, true);

        if ($otpArray['code'] == "000") {
            $otpArray = json_decode($otpJson, true);

            $responseStatus = $this->formatJsonData('00000', 'requestOTP', '', '', 'SUCCESS');
            $data['refCode'] = $otpArray['result']['ref_code'];
        } else {
            $responseStatus = $this->formatJsonData('90000', 'requestOTP', 'Unknown error', 'Popup', 'ERROR');
            $data[] = null;
        }

        return response()->json(['responseStatus' => $responseStatus, 'data' => $data]);
    }

    public function verifyUserWithOTP()
    {
        $credentials = request()->only(['refCode', 'otpCode', 'IdentityNumber']);
        if (in_array(null, $credentials, true)) {
            $responseStatus = $this->formatJsonData('20001', 'verifyOTP', '', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null]);
        }


        $otpJson = $this->verifyOTP($credentials['refCode'], $credentials['otp']);
        $otpArray = json_decode($otpJson, true);

        if ($otpArray['code'] == "000") {
            $responseStatus = $this->formatJsonData('00000', 'verifyUserWithOTP', '', '', 'SUCCESS');
            $data['refCode'] = $otpArray['result']['ref_code'];
        } else {
            $responseStatus = $this->formatJsonData('90000', 'verifyUserWithOTP', 'Unknown error', 'Popup', 'ERROR');
            $data[] = null;
        }

        return response()->json(['responseStatus' => $responseStatus, 'data' => $data]);
    }

    private function createTags($customer_id, $credentials, $decryptedCredentials, $detailsCredo = null)
    {
        DB::beginTransaction();
        try {
            $dataTag = Data_CusTags::where('DataCus_id', $customer_id)->where('Status_Tag', 'active')->first();

            if (!$dataTag) {
                $zone = DB::table('TB_Branchs')->where('id', $credentials['branchId'])->value('Zone_Branch');
                $credoCode = $this->runCredoCode($customer_id, $decryptedCredentials['phoneNumber'], $credentials['deviceId'], $credentials['deviceName'], 'mobile CN', $detailsCredo);

                $tags = new Data_CusTags;
                $tags->DataCus_id = $customer_id;
                $tags->date_Tag = date('Y-m-d');
                $tags->Code_Tag = $this->runBillTags(date('Y-m-d'), 'TAG', $zone);
                $tags->Status_Tag = 'active';
                $tags->BranchCont = $credentials['branchId'];

                $tags->Credo_Code = $credoCode;
                $tags->Type_Customer = 'CUS-0001';
                $tags->Resource_Customer = 'CRS-0021';

                $tags->UserZone = $zone;
                $tags->UserBranch = $credentials['branchId'];
                $tags->UserInsert = 'mobile CN';
                $tags->save();

            } else {
                $credoCode = null;
            }
            DB::commit();

            return $credoCode;
        } catch (\Exception $e) {
            DB::rollback();

            return $credoCode = null;
        }
    }
}
