<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\TB_Assets\Data_Assets;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_paydueLoan;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_RENEWCONTRACT;
use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_CHQMas;
use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_CHQTran;
use App\Models\TB_temp\TMP_ARLOST\TMP_ARLOSTHP;
use App\Models\TB_temp\TMP_ARLOST\TMP_ARLOSTPSL;
use App\Models\TB_temp\TMP_WAITHOLD\TMP_WAITHOLDHP;
use App\Models\TB_temp\TMP_WAITHOLD\TMP_WAITHOLDPSL;
use App\Models\TB_temp\TMP_STOPVAT\TMP_STOPVATHP;
use App\Models\TB_temp\TMP_STOPVAT\TMP_STOPVATPSL;

use App\Models\TB_view\View_ARHPReport;
use App\Models\TB_view\View_ARPSLReport;
use Illuminate\Http\Request;
use DB;
use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_Contracts;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_Contracts;
use App\Models\TB_Temp\TMP_CONTRACTS\TMP_CANCONTRACTHP;
use App\Models\TB_Temp\TMP_CONTRACTS\TMP_CANCONTRACTPSL;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

use App\Traits\PaymentsRequests;
use App\Events\backend\EventPayments;


class AccountController extends Controller
{
    use PaymentsRequests;
    public function index(Request $request)
    {
        $data = $request->data;
        // $CONTNO = $data['CONTNO'];
        $userZone = auth()->user()->zone;
        $locat = @$data['ID_LOCAT'];
        $CONTNO = @$data['CONTNO'];
        $NOPAY = @$data['NOPAY'];
        $saveType = @$request->data['saveType'];
        if ($request->page == 'stopcont-vats') {
            try {
                $dateVat = $data['DATEVAT'];
                if ($request->data['type_loan'] == 'HP') {
                    if ($request->data['saveType'] == 'stopvats') {
                        $res_data = PatchHP_Contracts::
                            when($locat != '999', function ($query) use ($locat) {
                                return $query->where("LOCAT", $locat);
                            })
                            ->when($CONTNO != NULL, function ($query) use ($CONTNO) {
                                return $query->where('CONTNO', $CONTNO);
                            })
                            ->when($NOPAY != NULL, function ($query) use ($NOPAY) {
                                return $query->where('HLDNO', '>=', $NOPAY);
                            })
                            ->whereRaw("(DTSTOPV = '' or DTSTOPV IS NULL)")
                            ->where('UserZone', $userZone)
                            ->get();

                        $returnView = view('backend.content-temp.section-stopvat.table', compact('res_data', 'dateVat', 'saveType'))->render();
                        return response()->json([
                            'htmlEl' => $returnView,
                            'data_res' => $res_data,
                            'message' => 'filter successfully',
                        ], 200);
                    } else if ($request->data['saveType'] == 'cancel-stopvats') {
                        $res_data = PatchHP_Contracts::
                            where("HLDNO", "<=", $data['NOPAY'])
                            ->when($locat != '999', function ($query) use ($locat) {
                                return $query->where("LOCAT", $locat);
                            })
                            ->when($CONTNO != NULL, function ($query) use ($CONTNO) {
                                return $query->where('CONTNO', $CONTNO);
                            })
                            ->when($NOPAY != NULL, function ($query) use ($NOPAY) {
                                return $query->where('HLDNO', '<=', $NOPAY);
                            })
                            ->whereRaw("(DTSTOPV <> '' or DTSTOPV IS NOT NULL)")
                            ->where('UserZone', $userZone)
                            ->get();

                        $returnView = view('backend.content-temp.section-stopvat.table', compact('res_data', 'dateVat', 'saveType'))->render();
                        return response()->json([
                            'htmlEl' => $returnView,
                            'data_res' => $res_data,
                            'message' => 'filter successfully',
                        ], 200);
                    }
                } else if ($request->data['type_loan'] == 'PSL') {
                    if ($request->data['saveType'] == 'stopvats') {
                        $res_data = PatchPSL_Contracts::
                            when($locat != '999', function ($query) use ($locat) {
                                return $query->where("LOCAT", $locat);
                            })
                            ->when($CONTNO != NULL, function ($query) use ($CONTNO) {
                                return $query->where('CONTNO', $CONTNO);
                            })
                            ->when($NOPAY != NULL, function ($query) use ($NOPAY) {
                                return $query->where('PatchPSL_Contracts.HLDNO', '>=', $NOPAY);
                            })
                            ->whereRaw("(DTSTOPV = '' or DTSTOPV IS NULL)")

                            ->where('UserZone', $userZone)
                            ->get();

                        $returnView = view('backend.content-temp.section-stopvat.table', compact('res_data', 'dateVat', 'saveType'))->render();
                        return response()->json([
                            'htmlEl' => $returnView,
                            'data_res' => $res_data,
                            'message' => 'filter successfully',
                        ], 200);
                    } else if ($request->data['saveType'] == 'cancel-stopvats') {
                        $res_data = PatchPSL_Contracts::
                            selectRaw("PatchPSL_Contracts.id AS PactID, PatchPSL_Contracts.*, TB_Branchs.*")
                            ->when($locat != '999', function ($query) use ($locat) {
                                return $query->where("LOCAT", $locat);
                            })
                            ->when($CONTNO != NULL, function ($query) use ($CONTNO) {
                                return $query->where('CONTNO', $CONTNO);
                            })
                            ->when($NOPAY != NULL, function ($query) use ($NOPAY) {
                                return $query->where('PatchPSL_Contracts.HLDNO', '<=', $NOPAY);
                            })
                            ->whereRaw("(DTSTOPV <> '' or DTSTOPV IS NOT NULL)")
                            ->where('UserZone', $userZone)
                            ->get();

                        $returnView = view('backend.content-temp.section-stopvat.table', compact('res_data', 'dateVat', 'saveType'))->render();
                        return response()->json([
                            'htmlEl' => $returnView,
                            'data_res' => $res_data,
                            'message' => 'filter successfully',
                        ], 200);
                    }
                }
            } catch (\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ], 500);
            }
        } else if ($request->page == 'summarize-vats') {
            try {
                $timestamp_F = strtotime($data['Fdate']);
                $Fdate_format = date('Y-m-d', $timestamp_F);
                $timestamp_T = strtotime($data['Tdate']);
                $Tdate_format = date('Y-m-d', $timestamp_T);
                $table = '';

                if ($request->data['TypeLoans'] == 'HP') {
                    $table = 'HP';
                    $res_data = TMP_STOPVATHP::
                        when($locat != '999', function ($query) use ($locat) {
                            return $query->where("LOCAT", $locat);
                        })
                        ->whereRaw(" STOPVDT BETWEEN '" . $Fdate_format . "' AND '" . $Tdate_format . "' AND UserZone = '" . $userZone . "'")->get();

                    $returnView = view("backend.content-temp.section-summarize.table-data", compact('res_data', 'table'))->render();
                    return response()->json([
                        'htmlEl' => $returnView,
                        'res_data' => $res_data,
                        'message' => 'Filter data successfully',
                    ], 200);
                } else if ($request->data['TypeLoans'] == 'PSL') {
                    $table = 'PSL';
                    $res_data = TMP_STOPVATPSL::
                        when($locat != '999', function ($query) use ($locat) {
                            return $query->where("LOCAT", $locat);
                        })
                        ->whereRaw(" STOPVDT BETWEEN '" . $Fdate_format . "' AND '" . $Tdate_format . "' AND UserZone = '" . $userZone . "'")->get();

                    $returnView = view("backend.content-temp.section-summarize.table-data", compact('res_data', 'table'))->render();
                    return response()->json([
                        'htmlEl' => $returnView,
                        'res_data' => $res_data,
                        'message' => 'Filter data successfully',
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ], 500);
            }
        }
        // else if ($request->page == 'cancel-stopvats') {
        //     dd(11111);
        //     try {
        //         $dateVat = $data['DATEVAT'];
        //         if ($request->data['type_loan'] == 'HP') {
        //             $res_data =  PatchHP_Contracts::
        //             leftJoin("TB_Branchs","PatchHP_Contracts.LOCAT","=","TB_Branchs.id")
        //             ->where("HLDNO", "<=" ,$data['NOPAY'])
        //             ->whereRaw("LOCAT = '". $data['ID_LOCAT'] ."' and  (DTSTOPV <> '' or DTSTOPV IS NULL)")
        //             ->where('UserZone',$userZone)
        //             ->get();

        //             $returnView = view('backend.content-temp.section-cancelstopvat.table', compact('res_data', 'dateVat'))->render();
        //             return response()->json([
        //                 'htmlEl' => $returnView,
        //                 'data_res' => $res_data,
        //                 'message' => 'filter successfully',
        //             ], 200);
        //         } else if ($request->data['type_loan'] == 'PSL') {
        //             $res_data =  PatchPSL_Contracts::
        //             leftJoin("TB_Branchs","PatchPSL_Contracts.LOCAT","=","TB_Branchs.id")
        //             ->where("HLDNO", "<=" ,$data['NOPAY'])
        //             ->whereRaw("LOCAT = '". $data['ID_LOCAT'] ."' and  (DTSTOPV <> '' or DTSTOPV IS NULL)")
        //             ->where('UserZone',$userZone)
        //             ->get();

        //             $returnView = view('backend.content-temp.section-cancelstopvat.table', compact('res_data', 'dateVat'))->render();
        //             return response()->json([
        //                 'htmlEl' => $returnView,
        //                 'data_res' => $res_data,
        //                 'message' => 'filter successfully',
        //             ], 200);
        //         }
        //     } catch (\Exception $e) {
        //         return response()->json([
        //             'message' => $e->getMessage(),
        //             'code' => $e->getCode(),
        //         ], 500);
        //     }
        // }
    }
    public function store(Request $request)
    {
        if ($request->page == 'terminate-letter') {
            DB::beginTransaction();
            try {
                //test updateOrCreate query
                if ($request->loanType == 1) {
                    $dataCAN = TMP_CANCONTRACTPSL::updateOrCreate(
                        [
                            'dataPact_id' => $request->DataPact_id, //check ID
                            'CANNO' => $request->CANNO, //check BILL
                        ],
                        [
                            'PatchCon_id' => $request->DataPact_id,
                            'dataPact_id' => $request->DataPact_id,
                            'CODLOAN' => $request->loanType,
                            'LOCAT' => $request->LOCAT,
                            'CANNO' => $request->CANNO,
                            'CONTNO' => $request->CONTNO,
                            'SDATE' => date('Y-m-d', strtotime($request->SDATE)),
                            'TOTPRC' => ($request->TOTPRC != NULL) ? str_replace(",", "", $request->TOTPRC) : NULL,
                            'SMPAY' => ($request->SMPAY != NULL) ? str_replace(",", "", $request->SMPAY) : NULL,
                            'TOTBAL' => ($request->TOTBAL != NULL) ? str_replace(",", "", $request->TOTBAL) : NULL,
                            'EXP_AMT' => ($request->EXP_AMT != NULL) ? str_replace(",", "", $request->EXP_AMT) : NULL,
                            'CANDATE' => $request->CANDATE,
                            'CANSTAT' => $request->CAUSE,
                            'BILLCOLL' => NULL,
                            'CHECKER' => NULL,
                            'USERCN' => NULL,
                            'CONTSTAT' => $request->CONTSTAT,
                            'PAYFOR' => ($request->PayCode != NULL) ? str_replace(",", "", $request->PayCode) : NULL,
                            'PAYAMT' => ($request->PAYAMT != NULL) ? str_replace(",", "", $request->PAYAMT) : NULL,
                            'MEMO1' => $request->MEMO1,
                            'REXP_PRD' => ($request->REXP_PRD != NULL) ? str_replace(",", "", $request->REXP_PRD) : NULL,
                            'EXP_FRM' => ($request->EXP_FRM != NULL) ? str_replace(",", "", $request->EXP_FRM) : NULL,
                            'EXP_TO' => ($request->EXP_TO != NULL) ? str_replace(",", "", $request->EXP_TO) : NULL,
                            'KANGINT' => NULL,
                            'TOTUPAY' => str_replace(",", "", $request->TOTUPAY),
                            'PAYDATE' => convertDateHumanToPHP($request->PAYDATE),
                            'PAYMENT' => ($request->PAYMENT != NULL) ? str_replace(",", "", $request->PAYMENT) : NULL,
                            'KEXP_AMT' => ($request->KEXP_AMT != NULL) ? str_replace(",", "", $request->KEXP_AMT) : NULL,
                            'KEXP_PRD' => ($request->KEXP_PRD != NULL) ? str_replace(",", "", $request->KEXP_PRD) : NULL,
                            'LASTCANDT' => convertDateHumanToPHP($request->LASTCANDT),
                        ]
                    );
                } else {
                    $dataCAN = TMP_CANCONTRACTHP::updateOrCreate(
                        [
                            'dataPact_id' => $request->DataPact_id, //check ID
                        ],
                        [
                            'PatchCon_id' => $request->DataPact_id,
                            'dataPact_id' => $request->DataPact_id,
                            'CODLOAN' => $request->loanType,
                            'LOCAT' => $request->LOCAT,
                            'CANNO' => $request->CANNO,
                            'CONTNO' => $request->CONTNO,
                            'SDATE' => date('Y-m-d', strtotime($request->SDATE)),
                            'TOTPRC' => ($request->TOTPRC != NULL) ? str_replace(",", "", $request->TOTPRC) : NULL,
                            'SMPAY' => ($request->SMPAY != NULL) ? str_replace(",", "", $request->SMPAY) : NULL,
                            'TOTBAL' => ($request->TOTBAL != NULL) ? str_replace(",", "", $request->TOTBAL) : NULL,
                            'EXP_AMT' => ($request->EXP_AMT != NULL) ? str_replace(",", "", $request->EXP_AMT) : NULL,
                            'CANDATE' => $request->CANDATE,
                            'CANSTAT' => $request->CAUSE,
                            'BILLCOLL' => NULL,
                            'CHECKER' => NULL,
                            'USERCN' => NULL,
                            'CONTSTAT' => $request->CONTSTAT,
                            'PAYFOR' => ($request->PayCode != NULL) ? str_replace(",", "", $request->PayCode) : NULL,
                            'PAYAMT' => ($request->PAYAMT != NULL) ? str_replace(",", "", $request->PAYAMT) : NULL,
                            'MEMO1' => $request->MEMO1,
                            'REXP_PRD' => ($request->REXP_PRD != NULL) ? str_replace(",", "", $request->REXP_PRD) : NULL,
                            'EXP_FRM' => ($request->EXP_FRM != NULL) ? str_replace(",", "", $request->EXP_FRM) : NULL,
                            'EXP_TO' => ($request->EXP_TO != NULL) ? str_replace(",", "", $request->EXP_TO) : NULL,
                            'KANGINT' => NULL,
                            'TOTUPAY' => str_replace(",", "", $request->TOTUPAY),
                            'PAYDATE' => convertDateHumanToPHP($request->PAYDATE),
                            'PAYMENT' => ($request->PAYMENT != NULL) ? str_replace(",", "", $request->PAYMENT) : NULL,
                            'KEXP_AMT' => ($request->KEXP_AMT != NULL) ? str_replace(",", "", $request->KEXP_AMT) : NULL,
                            'KEXP_PRD' => ($request->KEXP_PRD != NULL) ? str_replace(",", "", $request->KEXP_PRD) : NULL,
                            'LASTCANDT' => convertDateHumanToPHP($request->LASTCANDT),
                        ]
                    );
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        } elseif ($request->page == 'save-recontract') {

            $checkRenew = PatchPSL_RENEWCONTRACT::whereRaw("(CONTNO='" . @$request->CONTNO . "' OR NEWCONTNO = '" . @$request->NEWCONTNO . "' ) and FORMAT(cast(CANDATE as date),'yyyy-MM') ='" . date('Y-m') . "' ")->first();
            if ($checkRenew == NULL) {
                DB::beginTransaction();
                try {
                    $statement = DB::statement("EXEC dbo.Sp_ExtendShortPsl ?,?", [@$request->CONTNO, $request->LOCAT]);
                    PatchPSL_RENEWCONTRACT::Create([
                        'DataCus_id' => $request->DataCus_id,
                        'DataPact_id' => $request->DataPact_id,
                        'PatchCon_id' => @$request->PatchCon_id,
                        'LOCAT' => @$request->LOCAT
                        ,
                        'CANDATE' => @$request->LASTCANDT
                        ,
                        'CONTNO' => @$request->CONTNO
                        ,
                        'CUSCOD' => @$request->CUSCOD
                        ,
                        'SNAM' => @$request->SNAM
                        ,
                        'NAME1' => @$request->NAME1
                        ,
                        'NAME2' => @$request->NAME2
                        ,
                        'STRNO' => @$request->STRNO
                        ,
                        'REGNO' => @$request->REGNO
                        ,
                        'SDATE' => @$request->SDATE
                        ,
                        'TOTPRC' => @$request->TOTPRC
                        ,
                        'T_NOPAY' => @$request->T_NOPAY
                        ,
                        'SMPAY' => @$request->SMPAY
                        ,
                        'TOTBAL' => @$request->TOTBAL
                        ,
                        'EXP_AMT' => @$request->EXP_AMT
                        ,
                        'BILLCOLL' => @$request->BILLCOLL
                        ,
                        'CHECKER' => @$request->CHECKER
                        ,
                        'USERCN' => 'USERCN'
                        ,
                        'CONTSTAT' => 'C'
                        ,
                        'FUPAY' => @$request->FUPAY
                        ,
                        'LUPAY' => @$request->LUPAY
                        ,
                        'MEMO1' => @$request->MEMO1
                        ,
                        'REXP_PRD' => @$request->REXP_PRD
                        ,
                        'EXP_FRM' => @$request->EXP_FRM
                        ,
                        'EXP_TO' => @$request->EXP_TO
                        ,
                        'KANGINT' => @$request->KANGINT
                        ,
                        'LDATE' => @$request->LDATE
                        ,
                        'BLTCSHPRC' => @$request->blRETCSHPRC
                        ,
                        'RETCSHPRC' => @$request->RETCSHPRC
                        ,
                        'otherPay' => @$request->otherPay
                        ,
                        'FEERATE' => @$request->FEERATE   //อัตราค่าธรรมเนียม
                        ,
                        'FEETOTAMT' => @$request->FEETOTAMT //ดอกเบี้ย
                        ,
                        'FEEAMT' => @$request->FEEAMT    // ค่าธรรมเนียม
                        ,
                        'FLRATE' => @$request->FLRATE   // อัตราดอกเบี้ย
                        ,
                        'NPROFIT' => @$request->NPROFIT // ดอกเบี้ย
                        ,
                        'RETOTPRC' => @$request->RETOTPRC
                        ,
                        'ALLTOTPRC' => @$request->totallprc
                        ,
                        'RETNOPAY' => @$request->RETNOPAY
                        ,
                        'REFUPAY' => @$request->REFUPAY
                        ,
                        'RENUPAY' => @$request->RENUPAY
                        ,
                        'RELUPAY' => @$request->RELUPAY
                        ,
                        'REFLAG' => @$request->REFLAG
                        ,
                        'NEWCONTNO' => @$request->NEWCONTNO
                    ]);

                    $renewContract = PatchPSL_Contracts::where('CONTNO', @$request->CONTNO)->where('LOCAT', @$request->LOCAT)->first();

                    $datedue = substr($renewContract->LDATE, 8, 2);
                    $time = strtotime($renewContract->LDATE);
                    $nextdue = date("Y-m", strtotime("+1 month", $time)) . "-" . $datedue;
                    $n_nopay = @$renewContract->T_NOPAY + @$request->RETNOPAY;

                    // dd(@$request->LOCAT, @$request->NEWCONTNO, intval($renewContract->T_NOPAY) ,intval(@$request->RETNOPAY), @$request->REFUPAY,
                    // @$request->RELUPAY, '1', date('Y-m-d'), $nextdue,  @$request->ALLTOTPRC, intval(@$request->RETCSHPRC), $renewContract->TYPECON,$renewContract->INTLATE,'1');
                    $Paydue = DB::select(
                        "SELECT * FROM dbo.uft_adddueExtend(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                        [
                            @$request->LOCAT,
                            @$request->NEWCONTNO,
                            intval($renewContract->T_NOPAY),
                            intval(@$request->RETNOPAY),
                            @$request->REFUPAY,
                            @$request->RELUPAY,
                            '1',
                            date('Y-m-d'),
                            $nextdue,
                            @$request->ALLTOTPRC,
                            intval(@$request->RETCSHPRC),
                            $renewContract->TYPECON,
                            $renewContract->INTLATE,
                            '1'
                        ]
                    );

                    foreach ($Paydue as $key => $value) {
                        $item = new PatchPSL_paydueLoan; //เงินกู้ที่ดิน + เงินกู้ระยะสั้น
                        $item->PatchCon_id = $renewContract->id;
                        $item->contno = $value->contno;
                        $item->locat = $value->locat;
                        $item->nopay = $value->nopay;
                        $item->ddate = $value->ddate;
                        $item->damt = $value->damt;
                        $item->capital = $value->capital;
                        $item->interest = $value->interest;
                        $item->FEEINT = $value->feeint;
                        $item->irr = $value->irr;
                        $item->capitalbl = $value->capitalbl;
                        $item->daycalint = $value->daycalint;
                        $item->save();
                    }
                    $updateDue = PatchPSL_paydueLoan::where('CONTNO', @$request->CONTNO)->where('NOPAY', intval($renewContract->T_NOPAY))->first();
                    $updateDue->capital = 0;
                    $updateDue->update();
                    $NETPROFIT = @$request->totallprc - @$request->RETCSHPRC;
                    $renewContract->LDATE = $nextdue;
                    $renewContract->INTFLATRATE = @$request->FLRATE;
                    $renewContract->TOT_UPAY = @$request->REFUPAY;
                    $renewContract->TOTPRC = @$request->totallprc;
                    $renewContract->NETPROFIT = $NETPROFIT;
                    $renewContract->CAPITALBL = @$request->RETCSHPRC;
                    $renewContract->TONBALANCE = @$request->RETCSHPRC;
                    $renewContract->T_NOPAY = $n_nopay;
                    $renewContract->CONTNO = @$request->NEWCONTNO;
                    $renewContract->update();

                    // อัพเดตเลขที่สัญญา
                    if (@$request->CONTNO != @$request->NEWCONTNO) {
                        PatchPSL_paydueLoan::where('contno', @$request->CONTNO)->update(['contno' => @$request->NEWCONTNO]);
                        PatchPSL_CHQMas::where('CONTNO', @$request->CONTNO)->update(['CONTNO' => @$request->NEWCONTNO]);
                        PatchPSL_CHQTran::where('CONTNO', @$request->CONTNO)->update(['CONTNO' => @$request->NEWCONTNO]);
                    }



                    DB::commit();
                    return response()->json(['message' => 'ต่อสัญญาเรียบร้อย'], 200);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                }
            } else {
                return response()->json(['message' => "ต่อสัญญาซ้ำ"], 500);
            }
        } elseif ($request->page == 'bad-dept') {
            $model = $request->CODLOAN == 1 ? TMP_ARLOSTPSL::query() : TMP_ARLOSTHP::query();
            $dataUpdate = $request->CODLOAN == 1 ? PatchPSL_Contracts::query() : PatchHP_Contracts::query();
            DB::beginTransaction();
            try {
                $dataCAN = $model->updateOrCreate(
                    [
                        'dataPact_id' => $request->dataPact_id, //check ID
                    ],
                    [
                        'PatchCon_id' => $request->PatchCon_id,
                        'DataCus_id' => $request->DataCus_id,
                        'dataPact_id' => $request->dataPact_id,
                        'LOCAT' => $request->LOCAT,
                        'CONTNO' => $request->CONTNO,
                        'Vehicle_License' => $request->Vehicle_License,
                        'Firstname' => $request->Firstname,
                        'Lastname' => $request->Lastname,
                        'PRICE' => ($request->PRICE != NULL) ? str_replace(",", "", $request->PRICE) : NULL,
                        'TOTSMACC' => $request->TOTSMACC,
                        'REMAININT' => $request->REMAININT,
                        'Vehicle_Chassis' => $request->Vehicle_Chassis,
                        'SMPAY' => ($request->SMPAY != NULL) ? str_replace(",", "", $request->SMPAY) : NULL,
                        'EXP_AMT' => ($request->EXP_AMT != NULL) ? str_replace(",", "", $request->EXP_AMT) : NULL,
                        'TYPEBDEBT' => $request->TYPEBDEBT,
                        'PRICEASST' => ($request->PRICEASST != NULL) ? str_replace(",", "", $request->PRICEASST) : NULL,
                        'SDATE' => $request->SDATE,
                        'DATEBDEBT' => $request->DATEBDEBT,
                        'MEMO' => $request->MEMO,
                        'UserZone' => auth()->user()->zone,
                        'UserBranch' => auth()->user()->branch,
                        'UserInsert' => auth()->user()->id
                    ]
                );

                $dataUpdate->where('id', $request->PatchCon_id)->first()->update([
                    "CONTSTAT" => "L",
                    "CLOSTAT" => "L",
                    "CLOSAR" => date('Y-m-d')
                ]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }

        } elseif ($request->page == 'save-seized') {
            $data = $request->CODLOAN == 1 ? TMP_WAITHOLDPSL::query() : TMP_WAITHOLDHP::query();
            DB::beginTransaction();
            try {
                $data->updateOrCreate(
                    [
                        'dataPact_id' => $request->DataPact_id, //check ID
                    ],
                    [
                        "DataCus_id" => $request->DataCus_id,
                        "PatchCon_id" => $request->PatchCon_id,
                        "CODLOAN" => $request->CODLOAN,
                        "CONTNO" => $request->CONTNO,
                        "SDATE" => $request->SDATE,
                        "LOCAT" => $request->LOCAT,
                        "Vehicle_Chassis" => $request->Vehicle_Chassis,
                        "Vehicle_NewLicense" => $request->Vehicle_NewLicense,
                        "TOTPRC" => $request->TOTPRC,
                        "SMPAY" => $request->SMPAY,
                        "BALANCE" => floatVal(($request->BALANCE != NULL) ? str_replace(",", "", $request->BALANCE) : NULL),
                        "DEBTBALANCE" => floatVal(($request->DEBTBALANCE != NULL) ? str_replace(",", "", $request->DEBTBALANCE) : NULL),
                        "EXP_PRD" => floatval($request->EXP_PRD),
                        "EXP_FRM" => floatval($request->EXP_FRM),
                        "EXP_TO" => floatval($request->EXP_TO),
                        "CONTSTAT" => $request->CONTSTAT,
                        "OLDCODE" => $request->OLDCODE,
                        "OLDNAME" => $request->OLDNAME,
                        "PAYFOR_CODE" => $request->PAYFOR_CODE,
                        "PAYFOR_NAME" => $request->PAYFOR_NAME,
                        "YDATE" => $request->YDATE,
                        "NETYDATE" => $request->NETYDATE,
                        "asset_id" => $request->asset_id, // เอาออก ใช้ real ของสัญญาวิ่งไปหาทรัพย์แทน กรณีมีหลายทรัพย์
                        "memo" => $request->memo,
                        "AMOUNT" => $request->AMOUNT,
                        "DEBTINT" => $request->DEBTINT,
                        'UserZone' => auth()->user()->zone,
                        'UserBranch' => auth()->user()->branch,
                        'UserInsert' => auth()->user()->id
                    ]
                );
                $queryData = $data->where('PatchCon_id', $request->PatchCon_id)->first();
                event(new EventPayments('UpdateContract', 'Update-save-seized', $queryData->PatchContract));

                DB::commit();
                return response(["IDHLD" => $queryData->id]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }

        } elseif ($request->page == 'save-Stock') {
            $data = $request->CODLOAN == 1 ? TMP_WAITHOLDPSL::query() : TMP_WAITHOLDHP::query();
            DB::beginTransaction();
            try {
                $data->updateOrCreate(
                    [
                        "id" => $request->IDHLD,
                    ],
                    [
                        "RBOOKVALUE" => $request->RBOOKVALUE,
                        "RTAX" => $request->RTAX,
                        "RINT" => $request->RINT,
                        "TBOOKVALUE" => $request->TBOOKVALUE,
                        "TTAX" => $request->TTAX,
                        "TINT" => $request->TINT,
                        "BEFORETAX" => $request->BEFORETAX,
                        "TAXVALUE" => $request->TAXVALUE,
                        "STSSTOCK" => 'Y'
                    ]
                );
                $queryData = $data->where("id", $request->IDHLD)->first();
                event(new EventPayments('UpdateContract', 'Update-save-Stock', $queryData->PatchContract));

                DB::commit();
                $dataSeized = $data->where('id', $request->IDHLD)->first();
                $view = view('backend.content-temp.section-seized.form-seized', compact('dataSeized'))->render();
                return response(['html' => $view]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        } elseif ($request->page == 'removeStock') {
            $data = $request->CODLOAN == 1 ? TMP_WAITHOLDPSL::query() : TMP_WAITHOLDHP::query();

            $data->updateOrCreate(
                [
                    "id" => $request->IDHLD,
                ],
                [
                    "RBOOKVALUE" => NULL,
                    "RTAX" => NULL,
                    "RINT" => NULL,
                    "TBOOKVALUE" => NULL,
                    "TTAX" => NULL,
                    "TINT" => NULL,
                    "BEFORETAX" => NULL,
                    "TAXVALUE" => NULL,
                    "STSSTOCK" => NULL
                ]
            );

            $dataSeized = $data->where('id', $request->IDHLD)->first();
            event(new EventPayments('UpdateContract', 'Update-removeStock', $dataSeized->PatchContract));

            $view = view('backend.content-temp.section-seized.form-seized', compact('dataSeized'))->render();
            return response(['html' => $view]);
        } else if ($request->page == 'save-stopvat') {
            try {
                if ($request->data['saveType'] == 'stopvats') {
                    $data = $request->data;
                    for ($i = 0; $i < count($request->idstop); $i++) {
                        $res_save = DB::statement("exec dbo.sp_CrtStopVat ?,?,?,?,?,?,?", [
                            $data['DATEVAT'],
                            auth()->user()->zone,
                            $data['NOPAY'],
                            $data['type_loan'],
                            auth()->user()->id,
                            $data['ID_LOCAT'],
                            $request->idstop[$i],
                        ]);
                    }

                    return response()->json([
                        "res_data" => $res_save,
                        "message" => 'save data successfully'
                    ], 200);
                } else if ($request->data['saveType'] == 'cancel-stopvats') {
                    $data = $request->data;
                    for ($i = 0; $i < count($request->idstop); $i++) {
                        $res_save = DB::statement("exec dbo.sp_CrtStopVatCancel ?,?,?,?,?,?,?", [
                            $data['DATEVAT'],
                            auth()->user()->zone,
                            $data['NOPAY'],
                            $data['type_loan'],
                            auth()->user()->id,
                            $data['ID_LOCAT'],
                            $request->idstop[$i],
                        ]);

                        // dump($request->idstop[0], $data, $res_save);
                    }

                    return response()->json([
                        "res_data" => $res_save,
                        "message" => 'save data successfully'
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        }
    }
    public function create(Request $request)
    {
        if ($request->page == 'CreateToStock') {
            $id = $request->IDHLD;
            $CONTTYP = $request->CONTTYP;
            $dataHLD = $request->CODLOAN == 1 ? TMP_WAITHOLDPSL::find($id) : TMP_WAITHOLDHP::find($id);
            // $data =  $request->CODLOAN == 1 ? View_ARPSLReport::where('CONTNO',$request->CONTNO)->first() : View_ARHPReport::where('CONTNO',$request->CONTNO)->first();
            if ($request->CODLOAN == 1) {
                if ($request->CONTTYP == 1) { //รถยนต์
                    $Results = DB::select('SELECT * FROM utf_RepDueEffr(?,?,?,?,?)', ['%', $request->CONTNO, date('Y-m') . '-01', date('Y-m-d'), auth()->user()->zone]);
                } elseif ($request->CONTTYP == 2) { //ที่ดิน
                    $Results = DB::select('SELECT * FROM utf_RepDueLand(?,?,?,?,?)', ['%', $request->CONTNO, date('Y-m') . '-01', date('Y-m-d'), auth()->user()->zone]);
                } elseif ($request->CONTTYP == 3) { //ระยะสั้น
                    $Results = DB::select('SELECT * FROM  utf_RepDueLandShort(?,?,?,?,?)', ['%', $request->CONTNO, date('Y-m') . '-01', date('Y-m-d'), auth()->user()->zone]);
                }

                $data = json_decode(json_encode($Results), true);
                //dd(@$data[0]["id"] );
            } else {
                $Results = DB::select('SELECT * FROM utf_HPRepDueEffr(?,?,?,?,?)', ['%', $request->CONTNO, date('Y-m') . '-01', date('Y-m-d'), auth()->user()->zone]);
                $data = json_decode(json_encode($Results), true);
            }
            // $intBl = $request->CODLOAN == 1 ? DB::select('SELECT * FROM utf_RepDueEffr(?,?,?,?,?)',['%',$request->CONTNO,'2024-07-01',date('Y-m-d'),auth()->user()->zone]) ;
            return view('backend.content-temp.section-seized.CreateToStock', compact('id', 'data', 'dataHLD', 'CONTTYP'));
        }
    }
    public function edit(Request $request, $id)
    {   //select contract
        if ($request->page == 'terminate-letter') {
            /*** set value search */
            $page_type = 'backend';
            $page = $request->page;
            $pageUrl = $request->page;
            $typeSreach = 'contract';
            $dataSreach = [
                'namecus' => true,
                'idcardcus' => true,
                'license' => true,
                'contract' => true,
            ];

            $pact = Pact_Contracts::where('id', $id)->first();

            if ($pact->ContractToTypeLoan->Loan_Com == 1) {     //เงินกู้
                $PatchCon_id = $pact->ContractToConPSL->id;

                $contract = PatchPSL_Contracts::where('DataPact_id', $pact->id)
                    ->with('ContractCHQMaspay')
                    ->with([
                        'ContractPaydue' => function ($query) use ($PatchCon_id) {
                            $query->whereNotNull('date1')
                                ->with([
                                    'PaydueToDuepay' => function ($query) use ($PatchCon_id) {
                                        $query->where('PatchCon_id', $PatchCon_id);
                                    }
                                ]);
                        }
                    ])
                    ->first();

                $dataBill = DB::select("SELECT dbo.uft_runbillTerminateHP(?,?,?,?,?)", [intval(substr($contract->CONTNO, 6, 2)), intval($contract->UserZone), intval($contract->LOCAT), date('Y-m-d'), 'AC']);
            } else {   //เช่าซื้อ
                $contract = $pact->ContractToConHP;
                $dataBill = DB::select("SELECT dbo.uft_runbillTerminatePSL(?,?,?,?,?)", [intval(substr($contract->CONTNO, 6, 2)), intval($contract->UserZone), intval($contract->LOCAT), date('Y-m-d'), 'AC']);
            }
            $tab = $request->tab;
            $loanType = $pact->ContractToTypeLoan->Loan_Com;

            $Fdate1 = @$request->start;
            $Tdate1 = @$request->end;

            $start = date_create($Fdate1);
            $newfdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : NULL;
            $end = date_create($Tdate1);
            $newtdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : NULL;
            // session()->put('contract', $contract);
            // $dataBill = DB::select("SELECT dbo.uft_runbillTerminateHP(?,?,?,?,?)", [intval(substr($contract->CONTNO, 6, 2)), intval($contract->UserZone), intval($contract->LOCAT), date('Y-m-d'), 'AC']);
            $txtbill = json_decode(json_encode($dataBill), true);
            $Billno = $txtbill[0][''];

            return view('backend.content-temp.section-terminate.view', compact('pact', 'contract', 'tab', 'loanType', 'page_type', 'page', 'pageUrl', 'typeSreach', 'dataSreach', 'Fdate1', 'Tdate1', 'Billno'));
        }
    }
    public function show(Request $request, $id)
    {
        if ($request->page == 'terminate-letter') {
            // dd($request);
            $pact = Pact_Contracts::where('id', $request->id)->first();
            if ($pact->ContractToTypeLoan->Loan_Com == 1) {     //เงินกู้
                $PatchCon_id = $pact->ContractToConPSL->id;

                $contract = PatchPSL_Contracts::where('DataPact_id', $pact->id)
                    ->with('ContractCHQMaspay')
                    ->with([
                        'ContractPaydue' => function ($query) use ($PatchCon_id) {
                            $query->whereNotNull('date1')
                                ->with([
                                    'PaydueToDuepay' => function ($query) use ($PatchCon_id) {
                                        $query->where('PatchCon_id', $PatchCon_id);
                                    }
                                ]);
                        }
                    ])
                    ->first();
                $dataBill = DB::select("SELECT dbo.uft_runbillTerminatePSL(?,?,?,?,?)", [intval(substr($contract->CONTNO, 6, 2)), intval($contract->UserZone), intval($contract->LOCAT), date('Y-m-d'), 'KCF']);
            } else {                                              //เช่าซื้อ
                $contract = $pact->ContractToConHP;
                $dataBill = DB::select("SELECT dbo.uft_runbillTerminateHP(?,?,?,?,?)", [intval(substr($contract->CONTNO, 6, 2)), intval($contract->UserZone), intval($contract->LOCAT), date('Y-m-d'), 'ACN']);
            }
            $loanType = $pact->ContractToTypeLoan->Loan_Com;

            //dd(intval(substr($contract->CONTNO, 6, 2)), intval($contract->UserZone), intval($contract->LOCAT), date('Y-m-d'), 'AC');
            $txtbill = json_decode(json_encode($dataBill), true);
            $Billno = $txtbill[0][''];

            // dd(intval(substr($contract->CONTNO, 6, 2)), intval($contract->UserZone), intval($contract->LOCAT), date('Y-m-d'), 'AC',$dataBill,$Billno);
            $pageSub = $request->pageSub;
            return response()->view('backend.content-temp.section-terminate.info', compact('pact', 'contract', 'loanType', 'Billno', 'pageSub'));

        } elseif ($request->page == 'getSeized') {
            $dataPact = Pact_Contracts::find($id);
            $dataDB = $dataPact->ContractToTypeLoan->Loan_Com == 1 ? PatchPSL_Contracts::query() : PatchHP_Contracts::query();
            $data = $dataDB->where('DataPact_id', $id)->first();
            $calCloseAC = $this->calCloseAC($data->CODLOAN, $data->CONTTYP, $data->CONTNO, $data->LOCAT, date('Y-m-d'));
            // dd($calCloseAC);

            $html = view('backend.content-temp.section-seized.form-seized', compact('data', 'calCloseAC'))->render();
            return response()->json(['html' => $html]);
        } elseif ($request->page == 'getSeizedFromSearch') {
            $dataPact = Pact_Contracts::find($id);
            $dataDB = $dataPact->ContractToTypeLoan->Loan_Com == 1 ? TMP_WAITHOLDPSL::query() : TMP_WAITHOLDHP::query();
            $dataSeized = $dataDB->where('DataPact_id', $id)->first();
            $t = Pact_Contracts::limit(7000)->get();

            $flagPage = true;
            $html = view('backend.content-temp.section-seized.form-seized', compact('dataSeized', 'flagPage', 't'))->render();
            return response()->json(['html' => $html]);
        } elseif ($request->page == 'reContract') {
            $data = PatchPSL_Contracts::where('DataPact_id', $id)->first();
            $flagPage = true;
            $html = view('backend.content-temp.section-recontract.form-recontract', compact('data', 'flagPage'))->render();
            return response()->json(['html' => $html]);
        } elseif ($request->page == 'getBaddebt') {
            $dataPact = Pact_Contracts::find($id);
            $dataDB = $dataPact->ContractToTypeLoan->Loan_Com == 1 ? PatchPSL_Contracts::query() : PatchHP_Contracts::query();
            $data = $dataDB->where('DataPact_id', $id)->first();
            $html = view('backend.content-temp.section-badDebt.form', compact('data'))->render();
            return response()->json(['html' => $html]);

        } elseif ($request->page == 'getBaddebtFromSearch') { //
            $dataPact = Pact_Contracts::find($id);
            $dataDB = $dataPact->ContractToTypeLoan->Loan_Com == 1 ? TMP_ARLOSTPSL::query() : TMP_ARLOSTHP::query();
            $data = $dataDB->where('DataPact_id', $id)->first();
            // $html = view('backend.content-temp.section-badDebt.form',compact('data'))->render();
            // return response()->json(['html'=>$html]);

            $cacheKey = 'testView';
            // Cache::forget($cacheKey);
            // dd(!Cache::has($cacheKey));
            if (!Cache::has($cacheKey)) {
                $viewContent = View::make('backend.content-temp.section-badDebt.form', compact('data'))->render();
                Cache::put($cacheKey, $viewContent, 60 * 60); // Cache for desired minutes
                $viewContent = Cache::get($cacheKey);

                return response()->json(['html' => $viewContent, 'Cahce' => 'no']);

            }

            $viewContent = Cache::get($cacheKey);
            return response()->json(['html' => $viewContent, 'Cahce' => 'yes']);

            // dd($content);
        } elseif ($request->page == 'getRecontractFromSearch') { //
            $dataPact = Pact_Contracts::find($id);
            $dataDB = PatchPSL_RENEWCONTRACT::query();
            $data = $dataDB->where('DataPact_id', $id)->first();
            $html = view('backend.content-temp.section-recontract.form-recontract', compact('data'))->render();
            return response()->json(['html' => $html]);
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->page == 'deleteSeized') {
            $data = $request->CODLOAN == 1 ? TMP_WAITHOLDPSL::find($id) : TMP_WAITHOLDHP::find($id);
            $dataSeized = $data->where('id', $request->IDHLD)->first();
            event(new EventPayments('UpdateContract', 'Update-deleteSeized', $dataSeized->PatchContract, $data->CONTSTAT));
            $data->delete();

            $view = view('backend.content-temp.section-seized.form-seized', compact('dataSeized'))->render();
            return response(['html' => $view]);
        }
    }


}
