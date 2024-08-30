<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Imports\ImportDuepay;
use App\Models\TB_Constants\TB_Frontend\TB_CrossBank;
use App\Models\TB_temp\TMP_CTS\TMP_CTSDETAILS;
use App\Models\TB_temp\TMP_CTS\TMP_CTSHEADERS;
use App\Models\TB_temp\TMP_CTS\TMP_CTSPAYMENTS;
use App\Models\TB_temp\TMP_CTS\TMP_CTSTOTALS;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{

    public function show(Request $request, $id)
    {
        if ($request->funs == 'select-codloans') {
            $data = DB::table('VWBC_REPPAYDAILY')
                ->where('CODLOAN', $id)
                ->where('STAT', 'Y')
                ->where('POSTBL', 'N')
                ->get();

            if ($data) {
                if ($id == 1) {
                    $a_tite = 'สินเชื่อเงินกู้';
                } else {
                    $a_tite = 'สินเชื่อเช่าซื้อ';
                }
                
                $viewData = view('backend.content-payments.section-import.data-autopay', compact('data'))->render();
                return response()->json(['viewData' => $viewData, 'a_tite' => $a_tite], 200);
            } else {
                # code...
            }
            


        }
    }

    public function create(Request $request)
    {
        if ($request->funs == 'create-dataImport') {
            $detailBank = session()->get('detailBank');
            $headers = session()->get('dataHeader');
            $details = session()->get('dataDetails');
            $footers = session()->get('dataFooter');

            DB::beginTransaction();
            try {
                foreach ($headers as $key => $itemHeader) {
                    $header = new TMP_CTSHEADERS;
                    $header->RECORD_TYPE = $itemHeader[$key]['RECORD_TYPE'];
                    $header->SEQ_NO = $itemHeader[$key]['SEQ_NO'];
                    $header->BANK_CODE = $itemHeader[$key]['BANK_CODE'];
                    $header->COMPANY_ACCOUNT = $itemHeader[$key]['COMPANY_ACCOUNT'];
                    $header->COMPANY_NAME = $itemHeader[$key]['COMPANY_NAME'];
                    $header->EFF_DATE = $itemHeader[$key]['EFF_DATE'];
                    $header->SERVICE_CODE = $itemHeader[$key]['SERVICE_CODE'];
                    $header->save();

                    foreach ($details[$key] as $itemDetail) {
                        $detail = new TMP_CTSDETAILS;
                        $detail->HEADER_ID = $header->HEADER_ID;
                        $detail->RECORD_TYPE = $itemDetail['RECORD_TYPE'];
                        $detail->SEQ_NO = $itemDetail['SEQ_NO'];
                        $detail->BANK_CODE = $itemDetail['BANK_CODE'];
                        $detail->COMPANY_ACCOUNT = $itemDetail['COMPANY_ACCOUNT'];
                        $detail->PAYMENT_DATE = $itemDetail['PAYMENT_DATE'];
                        $detail->PAYMENT_TIME = $itemDetail['PAYMENT_TIME'];
                        $detail->CUSTOMER_NAME = $itemDetail['CUSTOMER_NAME'];
                        $detail->REF1 = $itemDetail['REF1'];
                        $detail->REF2 = $itemDetail['REF2'];
                        $detail->REF3 = $itemDetail['REF3'];
                        $detail->BRANCH_NO = $itemDetail['BRANCH_NO'];
                        $detail->TELLER_NO = $itemDetail['TELLER_NO'];
                        $detail->TRANSACTION_KIND = $itemDetail['TRANSACTION_KIND'];
                        $detail->TRANSACTION_CODE = $itemDetail['TRANSACTION_CODE'];
                        $detail->CHEQUE_NO = $itemDetail['CHEQUE_NO'];
                        $detail->AMOUNT = $itemDetail['AMOUNT'];
                        $detail->CHEQUE_BANK_CODE = $itemDetail['CHEQUE_BANK_CODE'];
                        $detail->save();
                    }

                    foreach ($footers[$key] as $itemFooter) {
                        $total = new TMP_CTSTOTALS;
                        $total->HEADER_ID = $header->HEADER_ID;
                        $total->RECORD_TYPE = $itemFooter['RECORD_TYPE'];
                        $total->SEQ_NO = $itemFooter['SEQ_NO'];
                        $total->BANK_CODE = $itemFooter['BANK_CODE'];
                        $total->COMPANY_ACCOUNT = $itemFooter['COMPANY_ACCOUNT'];
                        $total->TOTAL_DEBIT_AMOUT = $itemFooter['TOTAL_DEBIT_AMOUT'];
                        $total->TOTAL_DEBIT_TRANSACTION = $itemFooter['TOTAL_DEBIT_TRANSACTION'];
                        $total->TOTAL_CREDIT_AMOUNT = $itemFooter['TOTAL_CREDIT_AMOUNT'];
                        $total->TOTAL_CREDIT_TRANSACTION = $itemFooter['TOTAL_CREDIT_TRANSACTION'];
                        $total->save();
                    }
                }

                DB::commit();

                if (is_array($headers) && count($headers) > 0 && is_array($headers[0])) {
                    $mergedHeader = call_user_func_array('array_merge_recursive', $headers);
                }
                if (is_array($details) && count($details) > 0 && is_array($details[0])) {
                    $mergedDetails = call_user_func_array('array_merge_recursive', $details);
                }
                if (is_array($footers) && count($footers) > 0 && is_array($footers[0])) {
                    $mergedFooter = call_user_func_array('array_merge_recursive', $footers);
                }

                $viewCompany = view('backend.content-payments.section-import.data-company', compact('detailBank', 'details', 'mergedDetails'))->render();
                $viewimport = view('backend.content-payments.section-import.data-import', compact('mergedDetails'))->render();

                return response()->json(['import' => $viewimport, 'company' => $viewCompany], 200);
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        } elseif ($request->funs == 'process-data') {
            $dataView = DB::table('VWBC_REPPAYDAILY')
                ->where('STAT', 'Y')
                ->where('POSTBL', 'N')
                ->get();

            dd($request);

            // if ($dataView->count() > 0) {
            //     DB::beginTransaction();
            //     try {
            //         foreach ($dataView as $key => $itemHeader) {
            //             $ct_pays = new TMP_CTSPAYMENTS;
            //             $ct_pays->RECORD_TYPE = $itemHeader[$key]['RECORD_TYPE'];
            //             $ct_pays->SEQ_NO = $itemHeader[$key]['SEQ_NO'];
            //             $ct_pays->BANK_CODE = $itemHeader[$key]['BANK_CODE'];
            //             $ct_pays->COMPANY_ACCOUNT = $itemHeader[$key]['COMPANY_ACCOUNT'];
            //             $ct_pays->COMPANY_NAME = $itemHeader[$key]['COMPANY_NAME'];
            //             $ct_pays->EFF_DATE = $itemHeader[$key]['EFF_DATE'];
            //             $ct_pays->SERVICE_CODE = $itemHeader[$key]['SERVICE_CODE'];
            //             $ct_pays->save();
            //         }

            //         DB::commit();

            //         $viewCompany = view('backend.content-payments.section-import.data-company', compact('detailBank', 'details', 'mergedDetails'))->render();
            //         $viewimport = view('backend.content-payments.section-import.data-import', compact('mergedDetails'))->render();

            //         return response()->json(['import' => $viewimport, 'company' => $viewCompany], 200);
            //     } catch (\Exception $e) {
            //         DB::rollback();

            //         return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            //     }
            // }else{
            //     return response()->json(['message' => 'ไม่พบข้อมูลที่ต้องประมวลผล', 'code' => 500], 500);
            // }

        } elseif ($request->funs == 'clear-session') {
            $sessionKeysToDelete = request('session_keys');

            foreach ($sessionKeysToDelete as $sessionKey) {
                session()->forget($sessionKey);
            }

            return response()->json(['message' => 'Session cleared successfully']);
        }
    }

    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            $corssbank = TB_CrossBank::all()->pluck('actions')->toArray();

            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            // $fileName = time() . '_' . $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();
            $filePath = 'public/uploads/' . $fileName;

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            $Path = $file->storeAs('uploads', $fileName, 'public');

            // อ่านเนื้อหาจากไฟล์และแสดงใน response
            $fileContents = $file->getContent();
            $data = ($fileContents);
            // $data = iconv("TIS-620", "UTF-8", $fileContents);

            // matchingBanks
            $matchingBanks = array_filter($corssbank, function ($bank) use ($data) {
                return strpos($data, $bank) !== false;
            });

            if ($matchingBanks) {
                $config = $this->ConfigsReaderFiles(reset($matchingBanks));
                $detailBank = $config['detailCrossBK'];

                $data_lines = explode("\r\n", $data);
                $dataResult = array_values(array_filter(array_map('trim', $data_lines), 'strlen'));

                $dataHeader = [];
                $dataDetails = [];
                $dataFooter = [];
                foreach ($dataResult as $key => $item) {
                    if (strpos($item, 'H') === 0) {
                        $dataHeader[] = [
                            'RECORD_TYPE' => substr($item, intval($config['HeadRecType'][0]), intval($config['HeadRecType'][1])),
                            'SEQ_NO' => substr($item, intval($config['HeadSeqNo'][0]), intval($config['HeadSeqNo'][1])),
                            'BANK_CODE' => substr($item, intval($config['HeadBankCode'][0]), intval($config['HeadBankCode'][1])),
                            'COMPANY_ACCOUNT' => substr($item, intval($config['HeadCompAcc'][0]), intval($config['HeadCompAcc'][1])),
                            'COMPANY_NAME' => rtrim(mb_substr(iconv('Tis-620', 'utf-8', $item), intval($config['HeadCompName'][0]), intval($config['HeadCompName'][1]))),
                            'EFF_DATE' => substr($item, intval($config['HeadEffDate'][0]), intval($config['HeadEffDate'][1])),
                            'SERVICE_CODE' => substr($item, intval($config['HeadServiceCode'][0]), intval($config['HeadServiceCode'][1])),
                        ];
                    } elseif (strpos($item, 'D') === 0) {
                        $dataDetails[] = [
                            'RECORD_TYPE' => substr($item, intval($config['DetailRecType'][0]), intval($config['DetailRecType'][1])),
                            'SEQ_NO' => substr($item, intval($config['DetailSeqNo'][0]), intval($config['DetailSeqNo'][1])),
                            'BANK_CODE' => substr($item, intval($config['DetailBankCode'][0]), intval($config['DetailBankCode'][1])),
                            'COMPANY_ACCOUNT' => substr($item, intval($config['DetailCompAcc'][0]), intval($config['DetailCompAcc'][1])),
                            'PAYMENT_DATE' => substr($item, intval($config['DetailPaymentDate'][0]), intval($config['DetailPaymentDate'][1])),
                            'PAYMENT_TIME' => substr($item, intval($config['DetailPaymentTime'][0]), intval($config['DetailPaymentTime'][1])),
                            'CUSTOMER_NAME' => rtrim(mb_substr(iconv('Tis-620', 'utf-8', $item), intval($config['DetailCustName'][0]), intval($config['DetailCustName'][1]))),
                            'REF1' => rtrim(substr($item, intval($config['DetailRef1'][0]), intval($config['DetailRef1'][1]))),
                            'REF2' => rtrim(mb_substr(iconv('Tis-620', 'utf-8', $item), intval($config['DetailRef2'][0]), intval($config['DetailRef2'][1]))),
                            'REF3' => rtrim(mb_substr(iconv('Tis-620', 'utf-8', $item), intval($config['DetailRef3'][0]), intval($config['DetailRef3'][1]))),
                            'BRANCH_NO' => substr($item, intval($config['DetailBranchNo'][0]), intval($config['DetailBranchNo'][1])),
                            'TELLER_NO' => substr($item, intval($config['DetailTellerNo'][0]), intval($config['DetailTellerNo'][1])),
                            'TRANSACTION_KIND' => substr($item, intval($config['DetailKindTransaction'][0]), intval($config['DetailKindTransaction'][1])),
                            'TRANSACTION_CODE' => substr($item, intval($config['DetailTransactionCode'][0]), intval($config['DetailTransactionCode'][1])),
                            'CHEQUE_NO' => rtrim(substr($item, intval($config['DetailChequeNo'][0]), intval($config['DetailChequeNo'][1]))),
                            'AMOUNT' => substr($item, intval($config['DetailAmount'][0]), intval($config['DetailAmount'][1])),
                            'CHEQUE_BANK_CODE' => substr($item, intval($config['DetailChequeBankCode'][0]), intval($config['DetailChequeBankCode'][1])),
                        ];
                    } elseif (strpos($item, 'T') === 0) {
                        $dataFooter[] = [
                            'RECORD_TYPE' => substr($item, intval($config['TotalRecType'][0]), intval($config['TotalRecType'][1])),
                            'SEQ_NO' => substr($item, intval($config['TotalSeqNo'][0]), intval($config['TotalSeqNo'][1])),
                            'BANK_CODE' => substr($item, intval($config['TotalBankCode'][0]), intval($config['TotalBankCode'][1])),
                            'COMPANY_ACCOUNT' => substr($item, intval($config['TotalCompAccode'][0]), intval($config['TotalCompAccode'][1])),
                            'TOTAL_DEBIT_AMOUT' => substr($item, intval($config['TotalDebitAmount'][0]), intval($config['TotalDebitAmount'][1])),
                            'TOTAL_DEBIT_TRANSACTION' => substr($item, intval($config['TotalDebitTransaction'][0]), intval($config['TotalDebitTransaction'][1])),
                            'TOTAL_CREDIT_AMOUNT' => substr($item, intval($config['TotalCreditAmount'][0]), intval($config['TotalCreditAmount'][1])),
                            'TOTAL_CREDIT_TRANSACTION' => substr($item, intval($config['TotalCreditTransaction'][0]), intval($config['TotalCreditTransaction'][1])),
                        ];
                    }
                }

                session()->push('detailBank', $detailBank);
                session()->push('dataHeader', $dataHeader);
                session()->push('dataDetails', $dataDetails);
                session()->push('dataFooter', $dataFooter);

                return response()->json(['message' => 'อัปโหลดไฟล์สำเร็จ'], 200);
            } else {

                dd(404);
                return response()->json(['message' => 'ไม่พบไฟล์ที่อัปโหลด'], 400);
            }
        }
    }

    private function ConfigsReaderFiles($param)
    {
        $detailCrossBK = TB_CrossBank::where('actions', $param)
            ->with('CrossbankConfig')
            ->first();

        $attributes = $detailCrossBK->CrossbankConfig->getAttributes();
        $config = [];
        $config = array_map(function ($value) {
            return explode(',', $value);
        }, $attributes);

        $config['detailCrossBK'] = $detailCrossBK;
        return $config;
    }
}