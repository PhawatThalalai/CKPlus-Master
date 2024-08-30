<?php

namespace App\Http\Controllers\backend;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DateTime;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\TB_Constants\TB_Backend\TB_PAYFOR;
use App\Models\TB_Constant\TB_Backend\TB_SPDEBT;

use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_Contracts;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_paydue;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_Contracts;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_paydue;

use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_CHQMas;
use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_CHQTran;
use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_HEADPAYMENT;
use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_DUEPAYMENT;
use App\Models\TB_PatchContracts\TB_Payments\PatchHP\PatchHP_CHQMas;
use App\Models\TB_PatchContracts\TB_Payments\PatchHP\PatchHP_CHQTran;
use App\Models\TB_PatchContracts\TB_Payments\PatchHP\PatchHP_HEADPAYMENT;

use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_paydueLoan;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchPSL\PatchPSL_AROTHR;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchHP\PatchHP_AROTHR;

use App\Models\TB_temp\TMP_ACCTCLOSE\TMP_ACCTCLOSEHP;
use App\Models\TB_temp\TMP_ACCTCLOSE\TMP_ACCTCLOSEPSL;

use App\Models\TB_temp\TMP_INVOICE\TMP_INVOICE;

use App\Events\backend\EventPayments;
use App\Events\api\sendNotificationApp;

use App\Traits\PaymentsRequests;
use App\Traits\OTPRequests;
use App\Traits\UserApproved;

class PaymentsController extends Controller
{
    use PaymentsRequests, OTPRequests, UserApproved;

    public function index(Request $request)
    {
        if ($request->page == 'cn-pays') {
            if ($request->func == 'fresh') {
                $Fdate1 = @$request->start;
                $Tdate1 = @$request->end;

                $start = date_create($Fdate1);
                $newfdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : NULL;
                $end = date_create($Tdate1);
                $newtdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : NULL;

                $dataPsl = PatchPSL_CHQMas::select('id', 'PatchCon_id', 'CONTNO', 'LOCATREC', 'BILLNO', 'PAYTYP', 'CHQAMT', 'PAYDT', 'ASK_DT', 'ASK_USERID', 'TYPEPAY')
                    ->where('ASK_FLAG', 'N')
                    ->where('UserZone', auth()->user()->zone)
                    ->when(!empty($newfdate) && !empty($newtdate), function ($q) use ($newfdate, $newtdate) {
                        return $q->whereBetween(DB::raw(" FORMAT (cast(PAYDT as date), 'yyyy-MM-dd')"), [$newfdate, $newtdate]);
                    })
                    ->get();

                $dataHp = PatchHP_CHQMas::select('id', 'PatchCon_id', 'CONTNO', 'LOCATREC', 'BILLNO', 'PAYTYP', 'CHQAMT', 'PAYDT', 'ASK_DT', 'ASK_USERID', 'TYPEPAY')
                    ->where('ASK_FLAG', 'N')
                    ->where('UserZone', auth()->user()->zone)
                    ->when(!empty($newfdate) && !empty($newtdate), function ($q) use ($newfdate, $newtdate) {
                        return $q->whereBetween(DB::raw(" FORMAT (cast(PAYDT as date), 'yyyy-MM-dd')"), [$newfdate, $newtdate]);
                    })
                    ->get();

                $html = view('backend.content-payments.section-CnPay.view-content-Cnpay', compact('dataPsl', 'dataHp'))->render();

                return response()->json(array('message' => 'success', 'html' => $html));

            }
        }
    }
    public function create(Request $request)
    {
        if ($request->funs == 'dateDue') {
            // re connection session
            $contract = $this->dataContract($request->CODLOAN, $request->id);
            // session()->put('contract', $contract);

            $this->SessionCalints($contract, $request->dateDue);
            $dataPaydue = $this->CalUpDuePayment($contract->CODLOAN, $contract->CONTTYP, $contract->CONTNO, $contract->LOCAT, $request->dateDue, $contract);
            $Paydue = $dataPaydue['Paydue'];
            $priceCus = $dataPaydue['priceCus']; //ยอดชำระทั้งหมด (ในตาราง)
            $intamtCus = $dataPaydue['intamtCus']; //ยอดเบี้ยปรับล่าช้าทั้งหมด (ในตาราง)
            $vfollowCus = $dataPaydue['vfollowCus']; //ยอดค่าทวงถามทั้งหมด (ในตาราง)

            $enablePayfor = $this->enableCheckpayfor($contract->PactToAroth);
            $DateSer = $this->construct();
            $active_table = 'd-none'; //show sum tabble
            if ($contract->CODLOAN == 1) { //เงินกู้
                $html = view('backend.content-payments.section-view.view-tb-duepay', compact('contract', 'Paydue', 'active_table'))->render();
            } else {
                $html = view('backend.content-payments.section-view.view-tb-duepay-2', compact('contract', 'Paydue', 'active_table'))->render();
            }

            $active_memo = 'false';
            $viewContentCont = view('components.content-contract.backend.card-contracts', compact('contract', 'active_memo'))->render();
            return response()->json(
                array(
                    'html' => $html,
                    'DateSer' => $DateSer,
                    'priceCus' => $priceCus,
                    'intamtCus' => $intamtCus,
                    'vfollowCus' => $vfollowCus,
                    'StatPayOther' => $enablePayfor['StatPayOther'],
                    'StatPayOther_N' => $enablePayfor['StatPayOther_N'],
                    'PactToAroth' => count($contract->PactToAroth),
                    'viewContentCont' => $viewContentCont,
                )
            );
        } elseif ($request->funs == 'Payment') {
            // set value show
            $active_table = ''; //show sum tabble
            $payment = $request->payment;
            $contract = $this->dataContract($request->CODLOAN, $request->id);

            session()->forget('updateDue_' . $request->id . '/' . $request->CODLOAN);
            $this->SessionCalints($contract, $request->datePay);

            if ($contract->CODLOAN == 1) { //เงินกู้
                $tablePay = $this->inPutPay($contract->CODLOAN, $contract->CONTTYP, $contract->CONTNO, $contract->LOCAT, $request->datePay, $payment);

                $tablePaydue = $request->arrayPaydue;

                if (!empty($tablePay['Paydue'])) {
                    $Paydue = $tablePay['Paydue'];
                    $flagdue = array_filter($tablePay['Results'], function ($e) {
                        return $e->flagdue == 'N';
                    });


                    $sumflagdue = 0;
                    // if ($flagdue != null) {
                    //     foreach ($Paydue as $key => $row) {
                    //         if ($row['flagdue'] == 'Y') {
                    //             $due = $row['nopay'];
                    //             $filterTBflagdue = array_filter($tablePaydue, function ($e) use($due) {
                    //                 return $e[0] == $due;
                    //             });

                    //             $filterTBflagdue = reset($filterTBflagdue);
                    //             $sumflagdue = (intval($payment) - intval($filterTBflagdue[13]));
                    //         }
                    //     }
                    // }

                    if ($contract->CONTTYP == 1) { //เงินกู้
                        $priceCus = ($contract->TOT_UPAY * count($tablePay['Results'])); //เทียบยอด รับชำระ
                        // $interest = collect($tablePay['Results'])->sum('INTLATEAMT'); //เบี้ยปรับล่าช้า
                    } else {
                        $pricedue = floatval(collect($tablePay['Results'])->sum('dueamt'));
                        $priceCus = $pricedue;
                    }

                    // if ($contract->CONTTYP == 1 || $contract->CONTTYP == 3  ) {
                    $payton_inteff = $this->payton_inteff($contract, $request->datePay, $payment, $contract->CONTTYP);
                    $payAmts = $payton_inteff[0]['payamt'];
                    $payinteff = $payton_inteff[0]['payinteff'];
                    $payton = $payton_inteff[0]['payton'];
                    $payfollow = (!empty($payton_inteff[0]['payfollow']) ? $payton_inteff[0]['payfollow'] : 0);

                    $interest = $payton_inteff[0]['b_intamt']; //เบี้ยปรับล่าช้า

                    session()->put('updateDue_' . $request->id . '/' . $request->CODLOAN, $tablePay['Paydue']);
                    // } else {
                    //     $payton_inteff = NULL;
                    //     $payinteff = NULL;
                    //     $payton = NULL;
                    //     $interest = 0;
                    //     session()->put('PayTonInteff', NULL);
                    //     session()->put('updateDue', $tablePay['Paydue']);
                    // }

                } else {
                    $Paydue = NULL;
                    $priceCus = ceil($contract->CAPITALBL);
                    $interest = 0;
                    $sumflagdue = 0;
                    $ctFpay = PatchPSL_CHQTran::where('CONTNO', $contract->CONTNO)->max('NOPAY') - 1;
                    $payamt = $this->paymentAmt($contract->LOCAT, $contract->CONTNO, $ctFpay, $contract->CAPITALBL, $contract->LPAYD, $request->datePay, (($contract->Interest_IRR * 12) / 100), $payment);
                    $payAmts = $payamt[0]['payment'];
                    $payinteff = $payamt[0]['payinteff'];
                    $payton = $payamt[0]['payton'];
                    $payfollow = 0;
                    $flagdue = [];

                    session()->put('PayTonInteff', $payamt);
                    session()->put('updateDue_' . $request->id . '/' . $request->CODLOAN, NULL);
                }

                $viewData = view('backend.content-payments.section-view.view-tb-duepay', compact('contract', 'Paydue', 'payment', 'active_table', 'payAmts'))->render();
            } elseif ($contract->CODLOAN == 2) { //เช่าซื้อ
                $tablePay = $this->inPutPay($contract->CODLOAN, $contract->CONTTYP, $contract->CONTNO, $contract->LOCAT, $request->datePay, $payment);
                $Paydue = $tablePay['Paydue'];
                $flagdue = array_filter($tablePay['Results'], function ($e) {
                    return $e->flagdue == 'N';
                });

                $sumflagdue = 0;
                $priceCus = ($contract->TOT_UPAY * $contract->T_NOPAY); //เทียบยอด รับชำระ
                $interest = collect($tablePay['Results'])->sum('intamt'); //เบี้ยปรับล่าช้า

                $payton_inteff = $this->payton_inteff($contract, $request->datePay, $payment, $contract->CONTTYP);
                $payinteff = NULL;
                $payton = NULL;
                $payfollow = (!empty($payton_inteff[0]['payfollow']) ? $payton_inteff[0]['payfollow'] : 0);
                $payAmts = $payton_inteff[0]['payamt'];
                $interest = $payton_inteff[0]['b_intamt']; //เบี้ยปรับล่าช้า

                session()->put('updateDue_' . $request->id . '/' . $request->CODLOAN, $tablePay['Paydue']);

                $viewData = view('backend.content-payments.section-view.view-tb-duepay-2', compact('contract', 'Paydue', 'payment', 'active_table', 'payAmts'))->render();
            }

            $viewContentPay = view('backend.content-payments.section-view.view-contentPay', compact('contract', 'payAmts', 'interest', 'payinteff', 'payton', 'payfollow'))->render();
            return response()->json(
                array(
                    'html' => $viewData,
                    'priceCus' => $priceCus,
                    'flagdue' => $flagdue,
                    'sumflagdue' => $sumflagdue,
                    'viewContentCont' => $viewContentPay
                )
            );
        } elseif ($request->funs == 'OVRDUE') {


            // re connection session
            @$inputPay = 0;
            // $contract = session()->get('contract');
            $contract = $this->dataContract($request->CODLOAN, $request->id);
            if ($request->CODLOAN == $contract->CODLOAN && $request->id != $contract->id) {
                $contract = $this->dataContract($request->CODLOAN, $request->id);
            } elseif ($request->CODLOAN != $contract->CODLOAN) {
                $contract = $this->dataContract($request->CODLOAN, $request->id);
            }
            // check รายการใบแจ้งหนี้ ล่าสุด
            $FLAGINV = @$contract->ContractToInvoiceOne->DATENOPAY >= date('Y-m-d') && @$contract->ContractToInvoiceOne->STATUSPAY == NULL;
            if (empty($request->flag)) {
                $runBill = $this->runBillINVOICE($contract, date('Y-m-d'));
                return view('backend.content-payments.section-create.create-overdue', compact('contract', 'runBill', 'FLAGINV'));
            } elseif ($request->flag == 'search-datedue') {
                $payfor = TB_PAYFOR::where('STATUSREG', 'Y')->pluck('FORCODE')->toArray();
                $payfor = ['602', '507'];

                // $contract = session()->get('contract');
                $date = $request->date;
                $this->SessionCalints($contract, $date);

                if ($contract->CODLOAN == 1) {
                    $peroidQuery = ($contract->CONTTYP == 1)
                        ? "SELECT SUM(DUEAMT - PAYAMT) AS PAYMENT, SUM(INTLATEAMT) AS INTLATEAMT ,SUM(FOLLOWAMT) - SUM(PAYFOLLOW) AS PAYFOLLOW FROM PatchPSL_DUEPAYMENT WHERE PatchCon_id = {$contract->id} GROUP BY PatchCon_id"
                        : "SELECT SUM(damt - payment) AS PAYMENT, SUM(intamt) AS INTLATEAMT ,SUM(FOLLOWAMT) - SUM(PAYFOLLOW) AS PAYFOLLOW FROM PatchPSL_paydueLoan WHERE PatchCon_id = {$contract->id} GROUP BY PatchCon_id";

                    $Datapayint = PatchPSL_CHQTran::whereNot('FLAG', 'C')->where('PatchCon_id', $contract->id)->get();
                } else {
                    $peroidQuery = "SELECT SUM(damt - payment) AS PAYMENT, SUM(intamt) AS INTLATEAMT , SUM(FOLLOWAMT) - SUM(PAYFOLLOW) AS PAYFOLLOW FROM PatchHP_paydue WHERE PatchCon_id = {$contract->id} AND ddate <= '{$date}' GROUP BY PatchCon_id";
                    $Datapayint = PatchHP_CHQTran::whereNot('FLAG', 'C')->where('PatchCon_id', $contract->id)->get();
                }
                $peroid = DB::select($peroidQuery);
                $payint = [
                    "PAYINT" => $Datapayint->sum('PAYINT'),
                    "DSCINT" => $Datapayint->sum('DSCINT'),
                    "PAYFL" => $Datapayint->sum('PAYFL'),
                    "DSCPAYFL" => $Datapayint->sum('DSCPAYFL')
                ];
                // dd($peroid[0]->INTLATEAMT  - ($payint['PAYINT']+ $payint['DSCINT'])  );
                $holdCash = ($contract->CODLOAN == 1)
                    ? PatchPSL_HEADPAYMENT::where('PatchCon_id', $contract->id)->value('TOTAMT') ?? 0
                    : PatchHP_HEADPAYMENT::where('PatchCon_id', $contract->id)->value('TOTAMT') ?? 0;
                $ImPayfor = implode(',', $payfor);


                $arthQuery = ($contract->CODLOAN == 1)
                    ? "SELECT SUM(PAYAMT) AS PAYAMT ,SUM(DISCOUNT) AS DISCOUNT , SUM(BALANCE) AS BALANCE  FROM PatchPSL_AROTHR WHERE PatchCon_id = {$contract->id} AND PAYFOR IN ({$ImPayfor})"
                    : "SELECT SUM(PAYAMT) AS PAYAMT ,SUM(DISCOUNT) AS DISCOUNT , SUM(BALANCE) AS BALANCE  FROM PatchHP_AROTHR WHERE PatchCon_id = {$contract->id} AND PAYFOR IN ({$ImPayfor})";

                $dataPatch = ($contract->CODLOAN == 1)
                    ? PatchPSL_Contracts::find($contract->id)
                    : PatchHP_Contracts::find($contract->id);

                $calCloseAC = $this->calCloseAC($contract->CODLOAN, $contract->CONTTYP, $contract->CONTNO, $contract->LOCAT, date('Y-m-d'));
                // dd($calCloseAC,$dataPatch);
                $arth = DB::select($arthQuery)[0] ?? 0;
                $docDate = date('Y-m-d');


                $Resultarth = DB::table('View_AROTHR')
                    ->where('CODLOAN', $contract->CODLOAN)
                    ->where('PatchCon_id', $contract->id)
                    // ->whereIn('NOPAY', $nopay_values)
                    // ->whereIn('id', $request->AROTHR)
                    ->where('STATUSREG', 'Y')
                    ->select('id', 'NOPAY', 'PAYAMT', 'REGFL', 'DISCOUNT', 'FORCODE', 'FORDESC', 'BALANCE', 'EXP_PRD')
                    ->orderBy('NOPAY', 'ASC')
                    ->orderBy('REGFL', 'ASC')
                    ->get();

                $PayOther = $Resultarth;
                $html = view('backend.content-payments.section-create.TB-Aroth', compact('PayOther'))->render();

                return response()->json(["html" => $html, "peroid" => $peroid, "payint" => $payint, "holdCash" => @$holdCash, "arth" => @$arth, "docDate" => @$docDate, "dataPatch" => $dataPatch, "calCloseAC" => $calCloseAC]);
            } elseif ($request->flag == 'cal-Invoice') {

                $date = $request->date;

                $AROTHR = [];
                $PERIODNOPAY = [];
                $PAYAROTR = 0;
                $hold = false;
                $itemPay = [];
                $AROTHR_id = $request->AROTHR;
                $Resultarth = DB::table('View_AROTHR')
                    ->where('CODLOAN', $contract->CODLOAN)
                    ->where('PatchCon_id', $contract->id)
                    ->where('STATUSREG', 'Y')
                    ->select('id', 'NOPAY', 'PAYAMT', 'REGFL', 'DISCOUNT', 'FORCODE', 'FORDESC', 'BALANCE', 'EXP_PRD')
                    ->orderBy('NOPAY', 'ASC')
                    ->orderBy('REGFL', 'ASC')
                    ->get();


                $sumAroth = floatval(array_sum($Resultarth->whereIn('id', explode(",", $request->AROTHR))->pluck('BALANCE')->toArray()));
                $inputPay = floatval(@$request->INPUTPAY) - $sumAroth;

                $dataPaydue = $this->inPutPay($contract->CODLOAN, $contract->CONTTYP, $contract->CONTNO, $contract->LOCAT, $date, $inputPay);
                $nopay_values = array_column($dataPaydue['Paydue'], 'nopay');



                $dataUpduePayment = $this->CalUpDuePayment($contract->CODLOAN, $contract->CONTTYP, $contract->CONTNO, $contract->LOCAT, $date, $contract);
                $dataPayduePayment = array_filter($dataUpduePayment['Paydue'], function ($query) use ($nopay_values) {
                    return in_array($query['nopay'], $nopay_values);
                });
                $payton_inteff = $this->payton_inteff($contract, date('Y-m-d'), $inputPay, $contract->CONTTYP);

                $PayOther = $Resultarth;
                $TOTBLC = @$request->INPUTPAY - $PAYAROTR;
                $dataPayduePayment = $dataPaydue['Paydue'];

                $html = view('backend.content-payments.section-create.TB-Invoice', compact('PayOther', 'dataPayduePayment'))->render();

                return response()->json([
                    "dataPayduePayment" => $dataPayduePayment,
                    "TOTBLC" => $TOTBLC,
                    "PAYAROTR" => $PAYAROTR,
                    'AROTHR' => $AROTHR_id,
                    "hold" => $hold,
                    "PayOther" => $html,
                    'inputPay' => $inputPay,
                    'DISCOUNT' => $Resultarth->sum('DISCOUNT'),
                    'dataPayOther' => $PayOther
                ]);
            }
        } elseif ($request->funs == 'closeAC') { // บันทึกปิดบัญชี
            $contract = $this->dataContract($request->CODLOAN, $request->id);

            //-----------------------------------------------------
            if ($request->flag == 'ajax') { //date close account
                try {
                    $this->SessionCalints($contract, date('Y-m-d', strtotime(convertDateHumanToPHP($request->dateDuePay))));
                    $ajax_calCloseAC = $this->calCloseAC($contract->CODLOAN, $contract->CONTTYP, $contract->CONTNO, $contract->LOCAT, date('Y-m-d', strtotime(convertDateHumanToPHP($request->dateDuePay))));

                    return response()->json($ajax_calCloseAC, 200);
                } catch (\Throwable $th) {
                    return response()->json(['title' => 'ล้มเหลว', 'message' => 'ดำเนินการไม่สำเร็จ กรุณ่ลองใหม่อีกครั้ง !'], 500);
                }
            }
            //-----------------------------------------------------
            $this->SessionCalints($contract, date('Y-m-d'));
            if ($contract->CODLOAN == 1) { //เงินกู้
                $_payfor = TB_PAYFOR::where('STATUS', 'Y')
                    ->where('FORCODE', '006')
                    ->first();
                //------------------------------------------------------------------------
                $existing_close = TMP_ACCTCLOSEPSL::where('PatchCon_id', $contract->id)
                    ->get();
                //------------------------------------------------------------------------
            } else { // เช่าซื้อ
                $_payfor = TB_PAYFOR::where('STATUS', 'Y')
                    ->where('FORCODE', '007')
                    ->first();
                //------------------------------------------------------------------------
                $existing_close = TMP_ACCTCLOSEHP::where('PatchCon_id', $contract->id)
                    ->get();
                //------------------------------------------------------------------------
            }
            $LOCAT = auth()->user()->UserToBranch;
            $calCloseAC = $this->calCloseAC($contract->CODLOAN, $contract->CONTTYP, $contract->CONTNO, $contract->LOCAT, date('Y-m-d'));
            $docno = $this->runCloseBill($contract, date('Y-m-d'));
            $new_close = true;
            //------------------------------------------------------------------------
            return view('backend.content-payments.section-modal.create-close-AC', compact('contract', '_payfor', 'LOCAT', 'calCloseAC', 'docno', 'existing_close', 'new_close'));
        } elseif ($request->funs == 'tb-paydue') {
            $PatchCon_id = $request->id;
            if ($request->CODLOAN == 1) {
                $contract = PatchPSL_Contracts::where('id', $PatchCon_id)
                    ->with([
                        'ContractPaydue' => function ($query) use ($PatchCon_id) {
                            $query->select('id', 'PatchCon_id', 'nopay', 'ddate', 'date1', 'damt', 'payment', 'V_PAYMENT', 'N_PAYMENT')
                                ->whereNotNull('date1')
                                ->with([
                                    'PaydueToDuepay' => function ($query) use ($PatchCon_id) {
                                        $query->select('id', 'PatchCon_id', 'NOPAY', 'PAYDATE', 'PAYAMT', 'PAYINTEFF', 'PAYTON', 'TONBALANCE')
                                            ->where('PatchCon_id', $PatchCon_id);
                                    }
                                ]);
                        }
                    ])
                    ->with([
                        'ContractCHQMasfee' => function ($query) {
                            $query->withTrashed();
                        }
                    ])
                    ->select('id', 'CONTNO', 'CODLOAN', 'CONTTYP')
                    ->first();
            } else {
                $contract = PatchHP_Contracts::find($PatchCon_id);
            }
            $dataTHR = DB::table('View_AROTHR')
                ->where('PatchCon_id', $contract->id)
                ->where('CODLOAN', $contract->CODLOAN)
                ->get();
            return view('backend.content-payments.section-modal.view-tb-paydue', compact('contract', 'dataTHR'));

        } elseif ($request->funs == 'contentPaymentINV') {
            $modalID = $request->modalID;
            $data = TMP_INVOICE::where("PatchCon_id", $request->PatchCon_id)->whereNull('STATUSPAY')->orderBy("id", "DESC")->first();
            return view('backend.content-payments.section-create.form-payments', compact('modalID', 'data'));

        } elseif ($request->funs == 'search-debt') {
            $CODLOAN = $request->CODLOAN;
            $id = $request->id;
            return view('backend.content-payments.section-searchDebt.view-modal', compact('CODLOAN', 'id'));
        }
    }

    public function show(Request $request, $id)
    {
        $modalID = $request->modalID;
        if ($request->FlagBtn == 'create-Pay') {
            $contract = $this->dataContract($request->CODLOAN, $id);
            session()->put('contract', $contract);
            $TYPEPAY = $request->btn_typePay ?? 0;
            $BILLDT = date('Y-m-d', strtotime($request->BILLDT));

            if ($TYPEPAY == 'Payment') {
                // set value
                $NETPAY = $request->payment ?? 0;
                $DSCINT = $request->dic_payint ?? 0;
                $DSCPAYFL = $request->dic_dscint ?? 0;

                $PAYAMT = $request->paydue ?? 0;
                $PAYINT = $request->interest ?? 0;
                $payfollow = $request->payfollow ?? 0;
                $status_PAYFOR = $request->status_PAYFOR;

                $Billno = $this->runBill($contract, $BILLDT, 'DUE');
                $flag_page = $request->FlagBtn;

                $viewData = view('backend.content-payments.section-create.create-payment', compact('flag_page', 'TYPEPAY', 'NETPAY', 'DSCINT', 'DSCPAYFL', 'PAYINT', 'contract', 'BILLDT', 'payfollow', 'PAYAMT', 'status_PAYFOR', 'Billno'))->render();
            } elseif ($TYPEPAY == 'Payother') {
                $Billno = $this->runBill($contract, $BILLDT, 'OTH');
                $payfor = TB_PAYFOR::where('STATUSREG', 'Y')->pluck('FORCODE')->toArray();
                $PayOther = $contract->PactToAroth
                    ->where('BALANCE', '!=', 0)
                    ->whereNotIn('PAYFOR', $payfor)
                    ->groupBy('PAYFOR')->all();

                $viewData = view('backend.content-payments.section-create.create-paymentOther', compact('TYPEPAY', 'contract', 'PayOther', 'BILLDT', 'Billno'))->render();
            }
            return response()->json(array('html' => $viewData));
        } elseif ($request->FlagBtn == 'OVRDUE') {
            $CODLOAN = $request->CODLOAN;
            $CONTTYP = $request->CONTTYP;
            $date = $request->date == NULL ? date('Y-m-d') : $request->date;

            if ($CODLOAN == 1) {
                $dataCon = PatchPSL_Contracts::find($id);
            } else {
                $dataCon = PatchHP_Contracts::find($id);
            }


            $this->Calints($CODLOAN, $CONTTYP, $dataCon->CONTNO, $dataCon->LOCAT, $date);
            //  $this->UpdateDuepay($CODLOAN, $CONTTYP, $dataCon->CONTNO, $dataCon->LOCAT, $date);
            if ($CODLOAN == 1) {
                if ($CONTTYP == 1) {
                    $data = PatchPSL_paydue::querynopay($id);
                } else {
                    $data = PatchPSL_paydueLoan::querynopay($id);
                }
                $dataInt = DB::select('select sum(PAYINT) as PAYINT ,sum(DSCINT) as DSCINT from PatchPSL_CHQTran where PatchCon_id =' . $id . ' group by PatchCon_id');
            } else {
                $data = PatchHP_paydue::querynopay($id);
                $dataInt = DB::select('select sum(PAYINT) as PAYINT ,sum(DSCINT) as DSCINT from PatchHP_CHQTran where PatchCon_id =' . $id . ' group by PatchCon_id');
            }

            if ($request->func == 'search') {
                $html = view('backend.content-payments.section-create.TB-OVRDUE', compact('data', 'dataInt', 'CODLOAN', 'CONTTYP'))->render();
                return response()->json(['html' => $html]);

            }
            return view('backend.content-payments.section-create.modal-OVRDUE', compact('data', 'dataInt', 'CODLOAN', 'CONTTYP'));
        } elseif ($request->FlagBtn == 'discountAC') {
            $new_contract = false;
            // re connection session
            $contract = session()->get('contract');
            if ($request->CODLOAN == $contract->CODLOAN && $request->id != $contract->id) {
                $contract = $this->dataContract($request->CODLOAN, $request->id);
                $new_contract = true;
            } elseif ($request->CODLOAN != $contract->CODLOAN) {
                $contract = $this->dataContract($request->CODLOAN, $request->id);
                $new_contract = true;
            }

            //-------------------------------------------
            $calCloseAC = null;
            if ($request->flagPage == 'create') {
                $calCloseAC = session()->get('calCloseAC');
                if ($new_contract)
                    $calCloseAC = $this->calCloseAC($contract->CODLOAN, $contract->CONTTYP, $contract->CONTNO, $contract->LOCAT, $request->payDueDT);
            }
            return view('backend.content-payments.section-modal.AC-discount', compact('contract', 'calCloseAC'));
        } elseif ($request->FlagBtn == 'getDataInvoice') { // ดึงข้อมูลใบแจ้งหนี้หลังจากการสอบถาม
            $data = TMP_INVOICE::find($id);
            $PayOther = DB::table('View_AROTHR')
                ->where('CODLOAN', $data->CODLOAN)
                ->whereIn('id', explode(',', $data->IDAROTH))
                ->get();
            $html = view('backend.content-payments.section-create.flagform-invoice', compact('data', 'PayOther'))->render();
            return response()->json(['html' => $html]);
        } elseif ($request->FlagBtn == 'getHistoryInvoice') { // ประวัติการเพิ่มใบแจ้งหนี้ (สอบถาม)
            $data = TMP_INVOICE::where('PactCon_id', $id)->get();
            return view('backend.content-payments.section-create.history-invoice', compact('data', 'modalID'));
        } elseif ($request->FlagBtn == 'getActiveINV') { // ใบแจ้งหนี้ที่เพิ่มไว้แล้วยังไม่ได้ใช้
            if ($request->flag == 'search') {
                $data = TMP_INVOICE::find($request->id);
            } else {
                $data = TMP_INVOICE::where('PactCon_id', $request->PactCon_id)->orderBy("id", "desc")->first();
            }
            $contract = $this->dataContract($data->CODLOAN, $data->PatchCon_id);
            $date = $data->DATENOPAY;
            $dataPaydue = $this->inPutPay($contract->CODLOAN, $contract->CONTTYP, $contract->CONTNO, $contract->LOCAT, $date, @$data->INPUTPAY);
            $nopay_values = array_column($dataPaydue['Paydue'], 'nopay');
            // $nopay_values =[$data->IDAROTH];


            $dataUpduePayment = $this->CalUpDuePayment($contract->CODLOAN, $contract->CONTTYP, $contract->CONTNO, $contract->LOCAT, $date, $contract);
            $dataPayduePayment = array_filter($dataUpduePayment['Paydue'], function ($query) use ($nopay_values) {
                return in_array($query['nopay'], $nopay_values);
            });
            $AROTHR = [];
            $PERIODNOPAY = [];
            $PAYAROTR = 0;
            $hold = false;
            $itemPay = [];
            $Resultarth = DB::table('View_AROTHR')
                ->where('CODLOAN', $contract->CODLOAN)
                ->whereIn('id', explode(",", $data->IDAROTH))
                ->select('id', 'NOPAY', 'PAYAMT', 'REGFL', 'DISCOUNT', 'FORCODE', 'FORDESC')
                ->orderBy('NOPAY', 'ASC')
                ->orderBy('REGFL', 'ASC')
                ->get();
            $inputPay = @$data->INPUTPAY;

            foreach ($dataPayduePayment as $item) {
                $arth = $Resultarth->where('NOPAY', $item['nopay']);
                if (!$arth->isEmpty()) {
                    foreach ($arth as $value) {
                        $FlagAMT = $inputPay - ($value->PAYAMT - $value->DISCOUNT);
                        if ($FlagAMT >= 0) {
                            $AROTHR[] = $value->id;
                            $PAYAROTR += ($value->PAYAMT - $value->DISCOUNT);
                            $inputPay -= ($value->PAYAMT - $value->DISCOUNT);
                        }
                    }
                }

                // ตัดค่างวด
                if ($inputPay > 0) {
                    $balanceamt = ($item['dueamt'] - $item['payamt']) +
                        ($contract->CODLOAN == 1
                            ? $item['INTLATEAMT']
                            : $item['intamt']) + ($item['followamt'] - $item['payfollow']);
                    $FlaginputPay = $balanceamt - $inputPay;
                    $item['Sumdiff'] = $FlaginputPay < 0 ? 0 : $FlaginputPay;
                    $itemPay[] = $item;

                    // เช็คค่าอื่นๆคงเหลือ
                    $flagAROTHR = ($arth->sum('PAYAMT') - $arth->sum('DISCOUNT')) - $PAYAROTR > 0;

                    // ตรวจสอบไม่ให้ค่างวดหมดก่อนค่าอื่นๆ
                    if ($FlaginputPay <= 0 && $flagAROTHR) {
                        $hold = true;
                        break;
                    } else {
                        $inputPay -= $balanceamt;
                        if ($inputPay >= 0) {
                            $PERIODNOPAY[] = $item['nopay'];
                        }
                    }
                }
            }
            $PayOther = $Resultarth;
            $dataPayduePayment = $itemPay;
            $html = view('backend.content-payments.section-create.flagform-invoice', compact('data'))->render();
            $htmlTB = view('backend.content-payments.section-create.TB-Invoice', compact('PayOther', 'dataPayduePayment'))->render();

            return response()->json(['html' => $html, 'TOTBLC' => $data->TOTBLC, 'htmlTB' => $htmlTB, 'data' => $data]);
        } elseif ($request->FlagBtn == 'newINV') {
            $contract = $this->dataContract($request->CODLOAN, $request->id);
            $FLAGINV = false;
            if (empty($request->flag)) {
                $runBill = $this->runBillINVOICE($contract, date('Y-m-d'));
                $html = view('backend.content-payments.section-create.form-invoice', compact('contract', 'runBill', 'FLAGINV'))->render();
            }
            return response()->json(['html' => $html]);
        } elseif ($request->FlagBtn == 'get-AROTHR') {
            $dataTHR = DB::table('View_AROTHR')
                ->select('PatchCon_id', 'id', 'ARDATE', 'ARCONT', 'PAYFOR', 'FORDESC', 'PAYAMT', 'DISCOUNT', 'SMPAY', 'BALANCE', 'name', 'DDATE', 'CODLOAN')
                ->where('PatchCon_id', $id)
                ->where('CODLOAN', $request->codloan)
                ->where('BALANCE', '!=', '.00')
                ->where(function ($query) {
                    $query->where('BALANCE', '!=', '0.00')
                        ->where('BALANCE', '!=', '.00')
                        ->where('BALANCE', '!=', '0');
                })
                ->get();

            // dd($dataTHR);

            $countTHR = $dataTHR->count();

            $FlagBtn = $request->FlagBtn;
            $html = view('backend.content-payments.section-view.view-tb-payother', compact('dataTHR', 'FlagBtn'))->render();
            return response()->json(["html" => $html, "countTHR" => $countTHR]);
        } elseif ($request->FlagBtn == 'disACtoModal') {
            // $this->sendOTP('0937702324', 'test');
            // $this->sendMassages('0937702324');

            $contract = $this->dataContract($request->CODLOAN, $id);
            $calCloseAC = $this->calCloseAC($contract->CODLOAN, $contract->CONTTYP, $contract->CONTNO, $contract->LOCAT, $request->datePay);
            $userSentOTP = $this->getUserHandlerOTP();
            // $sentOTP = $this->sendMassages();
            // dd($sentOTP);

            return view('backend.content-payments.section-modal.distWithOTP', compact('contract', 'calCloseAC', 'userSentOTP'));
        } elseif ($request->FlagBtn == 'searchDebt') {
            $contract = $this->dataContract($request->CODLOAN, $request->id);
            $payfor = TB_PAYFOR::pluck('FORCODE')->toArray();
            // $contract = session()->get('contract');
            $date = $request->date;
            $getPost = $this->Calints($contract->CODLOAN, $contract->CONTTYP, $contract->CONTNO, $contract->LOCAT, $date);

            if ($contract->CODLOAN == 1) {
                $peroidQuery = ($contract->CONTTYP == 1)
                    ? "SELECT SUM(DUEAMT - PAYAMT) AS PAYMENT, SUM(INTLATEAMT) AS INTLATEAMT ,SUM(FOLLOWAMT) - SUM(PAYFOLLOW) AS PAYFOLLOW FROM PatchPSL_DUEPAYMENT WHERE PatchCon_id = {$contract->id} GROUP BY PatchCon_id"
                    : "SELECT SUM(damt - payment) AS PAYMENT, SUM(intamt) AS INTLATEAMT ,SUM(FOLLOWAMT) - SUM(PAYFOLLOW) AS PAYFOLLOW FROM PatchPSL_paydueLoan WHERE PatchCon_id = {$contract->id} GROUP BY PatchCon_id";

                $Datapayint = PatchPSL_CHQTran::whereNot('FLAG', 'C')->where('PatchCon_id', $contract->id)->get();
            } else {
                $peroidQuery = "SELECT SUM(damt - payment) AS PAYMENT, SUM(intamt) AS INTLATEAMT , SUM(FOLLOWAMT) - SUM(PAYFOLLOW) AS PAYFOLLOW FROM PatchHP_paydue WHERE PatchCon_id = {$contract->id} AND ddate <= '{$date}' GROUP BY PatchCon_id";
                $Datapayint = PatchHP_CHQTran::whereNot('FLAG', 'C')->where('PatchCon_id', $contract->id)->get();

            }
            $peroid = DB::select($peroidQuery);
            $payint = [
                "PAYINT" => $Datapayint->sum('PAYINT'),
                "DSCINT" => $Datapayint->sum('DSCINT'),
                "PAYFL" => $Datapayint->sum('PAYFL'),
                "DSCPAYFL" => $Datapayint->sum('DSCPAYFL')
            ];
            // dd($peroid[0]->INTLATEAMT  - ($payint['PAYINT']+ $payint['DSCINT'])  );
            $holdCash = ($contract->CODLOAN == 1)
                ? PatchPSL_HEADPAYMENT::where('PatchCon_id', $contract->id)->value('TOTAMT') ?? 0
                : PatchHP_HEADPAYMENT::where('PatchCon_id', $contract->id)->value('TOTAMT') ?? 0;
            $ImPayfor = implode(',', $payfor);

            $arthQuery = ($contract->CODLOAN == 1)
                ? "SELECT SUM(PAYAMT) AS PAYAMT ,SUM(DISCOUNT) AS DISCOUNT , SUM(BALANCE) AS BALANCE  FROM PatchPSL_AROTHR WHERE PatchCon_id = {$contract->id} AND PAYFOR IN ({$ImPayfor})"
                : "SELECT SUM(PAYAMT) AS PAYAMT ,SUM(DISCOUNT) AS DISCOUNT , SUM(BALANCE) AS BALANCE  FROM PatchHP_AROTHR WHERE PatchCon_id = {$contract->id} AND PAYFOR IN ({$ImPayfor})";

            $dataPatch = ($contract->CODLOAN == 1)
                ? PatchPSL_Contracts::find($contract->id)
                : PatchHP_Contracts::find($contract->id);

            $calCloseAC = $this->calCloseAC($contract->CODLOAN, $contract->CONTTYP, $contract->CONTNO, $contract->LOCAT, date('Y-m-d'));
            // dd($calCloseAC,$dataPatch);
            $arth = DB::select($arthQuery)[0] ?? 0;
            $docDate = date('Y-m-d');
            return response()->json(["peroid" => $peroid, "payint" => $payint, "holdCash" => @$holdCash, "arth" => @$arth, "docDate" => @$docDate, "dataPatch" => $dataPatch, "calCloseAC" => $calCloseAC]);
        } elseif ($request->FlagBtn == 'payment-Details') {
            if ($request->CODLOAN == 1) {
                $transaction = PatchPSL_CHQTran::find($id);
            } else {
                $transaction = PatchHP_CHQTran::find($id);
            }

            $status_PAYFOR = @$transaction->PAYFOR;
            $BILLDT = date('Y-m-d', strtotime($transaction->TMBILDT));
            $PAYAMT = $transaction->PAYAMT;
            $PAYINT = $transaction->PAYINT;
            $payfollow = $transaction->PAYFL;

            $DSCINT = $transaction->DSCINT;
            $DSCPAYFL = $transaction->DSCPAYFL;
            $NETPAY = ($transaction->PAYAMT + $DSCINT + $DSCPAYFL);

            $flag_page = $request->FlagBtn;
            return view('backend.content-payments.section-create.create-payment', compact('transaction', 'flag_page', 'status_PAYFOR', 'BILLDT', 'NETPAY', 'PAYAMT', 'PAYINT', 'DSCINT', 'payfollow', 'DSCPAYFL'));
        }
    }
    public function edit(Request $request, $id)
    {

        if ($request->page == 'payments') {
            //set vbalue
            $page = $request->page;
            $this->resetSession_alll();
            $DateSer = $this->construct();
            $pact = Pact_Contracts::selectRaw('id, DataCus_id, CodeLoan_Con, Contract_Con , Id_Com')
                ->where('id', $id)
                ->first();

            if ($pact->ContractToTypeLoan->Loan_Com == 1) { //เงินกู้ ( 1 เงินกู้, 3 ผ่อนดอกเบี้ย )
                $PatchCon_id = $pact->ContractToConPSL->id;
                $contract = PatchPSL_Contracts::where('DataPact_id', $pact->id)
                    ->withoutEagerLoads()
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
                    ->withCount([
                        'PactToAroth' => function ($query) {
                            $query->whereRaw('BALANCE != 0');
                        }
                    ])
                    ->with([
                        'ContractToSPASTDUE' => function ($query) {
                            $query->select('PatchCon_id', 'MinPay', 'MustPay');
                        }
                    ])
                    ->first();
            } else { //เช่าซื้อ
                // $contract = $pact->ContractToConHP;
                $PatchCon_id = $pact->ContractToConHP->id;
                $contract = PatchHP_Contracts::where('DataPact_id', $pact->id)
                    ->withoutEagerLoads()
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
                    ->withCount([
                        'PactToAroth' => function ($query) {
                            $query->whereRaw('BALANCE != 0');
                        }
                    ])
                    ->with([
                        'ContractToSPASTDUE' => function ($query) {
                            $query->select('PatchCon_id', 'MinPay', 'MustPay');
                        }
                    ])
                    ->first();
            }

            $enablePayfor = $this->enableCheckpayfor($contract->PactToAroth);
            $StatPayOther = $enablePayfor['StatPayOther'];
            $StatPayOther_N = $enablePayfor['StatPayOther_N'];

            // check รายการใบแจ้งหนี้
            // $statInvoice = $contract->ContractToInvoiceOne ? $contract->ContractToInvoiceOne->DATENOPAY == date('Y-m-d') && empty($contract->ContractToInvoiceOne->STATUSPAY) : NULL;

            $this->SessionCalints($contract, date('Y-m-d'));
            $dataPaydue = $this->CalUpDuePayment($contract->CODLOAN, $contract->CONTTYP, $contract->CONTNO, $contract->LOCAT, date('Y-m-d'), $contract);

            $TOTBLC = $contract->ContractToInvoiceOne ? $contract->ContractToInvoiceOne->TOTBLC : 0;
            $Paydue = $dataPaydue['Paydue'];
            $priceCus = $dataPaydue['priceCus']; //ยอดชำระทั้งหมด (ในตาราง)
            $intamtCus = $dataPaydue['intamtCus']; //ยอดเบี้ยปรับล่าช้าทั้งหมด (ในตาราง)
            $vfollowCus = $dataPaydue['vfollowCus']; //ยอดค่าทวงถามทั้งหมด (ในตาราง)

            // $tb_SPDEBT = TB_SPDEBT::where('month_debt',date('m', strtotime($contract->ContractToSPASTDUE->LAST_ASSIGNDT)))->first();
            // dd($tb_SPDEBT,$contract->ContractToSPASTDUE->LAST_ASSIGNDT);

            // check Minimun Payments
            $ResultMinPay = $this->minimumPaydue($Paydue, $contract);

            // $minutes = 60;
            // $keyContentProfile = 'profile-content-' . $id; // หรือตามชื่อเส้นทางของแท็บ
            // if (Cache::has($keyContentProfile)) {
            //     $contractHtml = Cache::get($keyContentProfile);
            // } else {
            //     $contractHtml = view('components.content-user.backend.view-profile-b-end', ['page' => 'payments', 'pact' => @$pact])->render();
            //     Cache::put($keyContentProfile, $contractHtml, $minutes);
            // }

            // $cacheStats = Cache::getStats();
            // Cache::pull('contract_html');
            // Cache::pull('payment_html');
            // Cache::flush();

            $active_table = 'd-none'; //show sum table
            session()->put('contract', $contract);
            return view(
                'backend.content-payments.view-payment',
                compact(
                    'pact',
                    'contract',
                    'Paydue',
                    'DateSer',
                    'active_table',
                    'priceCus',
                    'ResultMinPay',
                    'StatPayOther',
                    'StatPayOther_N',
                    'TOTBLC',
                    'intamtCus',
                    'vfollowCus',
                    'page'
                )
            );
        }
    }

    public function store(Request $request)
    {
        $contract = $this->dataContract($request->CODLOAN, $request->id);
        session()->put('contract', $contract);
        $DateSer = $this->construct();

        if ($request->page == 'payments') {
            if ($request->data['TYPEPAY'] == 'Payment') {
                $Billno = $this->runBill($contract, $request->data['BILLDT'], 'DUE');
            } else {
                $Billno = $this->runBill($contract, $request->data['BILLDT'], 'OTH');
            }
            session()->put('Billno', $Billno);
            $requestData = [
                'PAYAMT' => str_replace([","], "", @$request->data['PAYAMT']),
                'PAYINT' => str_replace([","], "", @$request->data['PAYINT']),
                'DSCINT' => str_replace([","], "", @$request->data['DSCINT']),
                'DISCT' => str_replace([","], "", @$request->data['DISCT']),      // ส่วนลดปิดบัญชี
                'DSCPAYFL' => str_replace([","], "", @$request->data['DSCPAYFL']),
                'payfollow' => str_replace([","], "", @$request->data['payfollow']),
                'BILLDT' => @$request->data['BILLDT'],
                'PAYTYP' => @$request->data['PAYTYP'],
                'PAYFOR' => @$request->data['PAYFOR'],
                'CHQDT' => @$request->data['CHQDT'] != NULL ? date('Y-m-d', strtotime(@$request->data['CHQDT'])) : NULL,
                'sumPay' => str_replace([","], "", $request->data['sumPay']),
                'PAYINACC' => @$request->data['PAYINACC'],
                'FLAG' => 'H',
                'INPDT' => date('Y-m-d'),
                'LOCATREC' => auth()->user()->branch,
                'TYPEPAY' => @$request->data['TYPEPAY'],
                'arrPay' => @$request->arrPay,
                'Memo' => @$request->data['pay_memo'],
                'UserInsert' => auth()->user()->id,
                'UserBranch' => auth()->user()->branch,
                'UserZone' => auth()->user()->zone,
            ];

            DB::beginTransaction();
            try {
                $ses_CHQMas = $this->store_CHQMas($requestData, $contract, $Billno);
                $ses_CHQTran = $this->store_CHQTran($requestData, $contract, $ses_CHQMas, $Billno);

                DB::commit();
                if (@$request->data['PAYFOR'] == '007') {
                    event(new EventPayments('UpdateContract', 'UpdatePayfor', $contract));
                }

                if ($contract->PactToCus->DataCusToAPI) {
                    $dataResponse = [
                        'accountId' => $contract->CONTNO,
                        'customerId' => $contract->DataCus_id,
                        'title' => 'รับชำระค่างวด',
                        'message' => 'บริษัทได้รับชำระค่างวดลูกค้าสัญญา ' . $contract->CONTNO . ' เรียบร้อยแล้ว ขอบคุณค่ะ',
                    ];
                    event(new sendNotificationApp($dataResponse));
                }

                if ($ses_CHQTran) {
                    $payAmt_Foll = floatval(@$requestData['PAYAMT']) + floatval(@$requestData['payfollow']);
                    if ($request->data['TYPEPAY'] == 'Payment') {
                        if ($contract->CODLOAN == 1) {
                            if ($contract->CONTTYP == 1 && !empty(session()->get('updateDue_' . $contract->id . '/' . $contract->CODLOAN))) {
                                foreach (session()->get('updateDue_' . $contract->id . '/' . $contract->CODLOAN) as $key => $value) {
                                    $DuePayt = PatchPSL_DUEPAYMENT::where('id', $value['id'])->update([
                                        'PAYAMT' => $value['payamt'],
                                        'PAYINTEFF' => $value['payinteff'],
                                        'PAYTON' => $value['payton'],
                                        'PAYFOLLOW' => $value['payfollow'],
                                        'PAYDATE' => date('Y-m-d'),
                                    ]);
                                }
                                $statement = DB::statement("EXEC dbo.sp_CaloverdueCpsl ?,?,?", [date('Y-m-d'), $contract->CONTNO, $contract->LOCAT]);
                            } elseif ($contract->CONTTYP == 2) {
                                // ย้ายเข้า trigger  $statement = DB::statement("EXEC dbo.sp_PrePaymentLand ?,?,?,?,?", [$Billno, $contract->CONTNO, $contract->LOCAT, date('Y-m-d'), $payAmt_Foll]);
                            } elseif ($contract->CONTTYP == 3) {
                                // ย้ายเข้า trigger $statement = DB::statement("EXEC dbo.sp_PrePaymentShort ?,?,?,?,?", [$Billno, $contract->CONTNO, $contract->LOCAT, date('Y-m-d'), $payAmt_Foll]);
                            }
                        } elseif ($contract->CODLOAN == 2) {
                            // ย้ายเข้า trigger $statement = DB::statement("EXEC dbo.sp_PrePaymentHp ?,?,?,?,?", [$Billno, $contract->CONTNO, $contract->LOCAT, date('Y-m-d'), $payAmt_Foll]);
                        }
                    }
                }

                $active_memo = false; //show memo
                $active_table = 'd-none'; //show sum tabble
                $dataPaydue = $this->CalUpDuePayment($contract->CODLOAN, $contract->CONTTYP, $contract->CONTNO, $contract->LOCAT, date('Y-m-d'), $contract);
                $Paydue = $dataPaydue['Paydue'];
                $priceCus = $dataPaydue['priceCus']; //ยอดชำระทั้งหมด (ในตาราง)
                $intamtCus = $dataPaydue['intamtCus']; //ยอดเบี้ยปรับล่าช้าทั้งหมด (ในตาราง)
                $vfollowCus = $dataPaydue['vfollowCus']; //ยอดค่าทวงถามทั้งหมด (ในตาราง)

                // call data contract
                $contract = $this->dataContract($contract->CODLOAN, $contract->id);
                session()->put('contract', $contract);

                // set value to report due_payments
                session()->put('data_CHQMas', $ses_CHQMas);
                session()->put('data_CHQTran', $ses_CHQTran);
                session()->put('Paydue', $Paydue);

                // รัน ขาดงวด
                $message = 'ชำระค่างวด เรียบร้อย ';
                if ($contract->CODLOAN == 1) {
                    $viewCon = view('components.content-contract.backend.card-contracts', compact('contract', 'active_memo'))->render();
                    $viewData = view('backend.content-payments.section-view.view-tb-duepay', compact('contract', 'Paydue', 'active_table'))->render();
                } elseif ($contract->CODLOAN == 2) {
                    $viewCon = view('components.content-contract.backend.card-contracts', compact('contract', 'active_memo'))->render();
                    $viewData = view('backend.content-payments.section-view.view-tb-duepay-2', compact('contract', 'Paydue', 'active_table'))->render();
                }

                return response()->json(['html' => $viewData, 'viewCon' => $viewCon, 'DateSer' => $DateSer, 'CHQMas_id' => $ses_CHQMas->id, 'priceCus' => $priceCus, 'intamtCus' => $intamtCus, 'vfollowCus' => $vfollowCus, 'message' => $message, 'code' => 200]);
            } catch (\Exception $e) {
                DB::rollback();

                session()->forget('data_CHQMas');
                session()->forget('data_CHQTran');
                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        } elseif ($request->page == 'closeAC') {
            $paymentDueDate = convertDateHumanToPHP($request->data['paymentDueDate']);
            DB::beginTransaction();
            try {
                //-------------------------------------------
                if ($request->data['codeloan'] == 1) { // เงินกู้ = 1
                    $accClose_record = new TMP_ACCTCLOSEPSL;
                    $patchCon_data = PatchPSL_Contracts::where('id', $request->data['patch_id'])->first();
                    $docno = $this->runCloseBill($patchCon_data, date('Y-m-d'));

                    if ($request->data['conttyp'] == 1) {
                        // เงินกู้ รถยนต์ / มอไซค์
                        $patchPaydue = $patchCon_data->ContractPaydue;
                    } else {
                        // อื่น ๆ (2 = เงินกู้ที่ดิน , 3 = ขายฝาก/จำนอง)
                        $patchPaydue = $patchCon_data->ContractPaydueLoan;
                    }

                } elseif ($request->data['codeloan'] == 2) { // เช่าซื้อ = 2
                    $accClose_record = new TMP_ACCTCLOSEHP;
                    $patchCon_data = PatchHP_Contracts::where('id', $request->data['patch_id'])->first();
                    $docno = $this->runCloseBill($patchCon_data, date('Y-m-d'));
                    $patchPaydue = $patchCon_data->ContractPaydue;
                }
                //dd($patchCon_data, $patchPaydue);
                $dataPact = $patchCon_data->PatchToPact;
                //-------------------------------------------
                $accClose_record->PatchCon_id = $request->data['patch_id'];
                $accClose_record->dataPact_id = $dataPact->id;
                $accClose_record->LOCAT = $request->data['contlocat'];
                $accClose_record->CRLOCAT = auth()->user()->UserToBranch->id;
                $accClose_record->DOCNO = $docno;
                $accClose_record->CANDATE = null;
                $accClose_record->CONTNO = $request->data['contno'];

                $accClose_record->CUSCOD = $patchCon_data->DataCus_id;

                $_sname = $patchCon_data->PactToCus->Prefix;
                if ($_sname == 'อื่น ๆ') {
                    $accClose_record->SNAM = $patchCon_data->PactToCus->PrefixOther;
                } else {
                    $accClose_record->SNAM = $_sname;
                }
                $accClose_record->NAME1 = $patchCon_data->PactToCus->Firstname_Cus;
                $accClose_record->NAME2 = $patchCon_data->PactToCus->Surname_Cus;

                //$accClose_record->STRNO =
                //$accClose_record->REGNO =

                $accClose_record->SDATE = $patchCon_data->SDATE;
                $accClose_record->TOTPRC = floatval($patchCon_data->TOTPRC);
                $accClose_record->SMPAY = floatval($patchCon_data->SMPAY);
                $accClose_record->BILLCOLL = $patchCon_data->BILLCOLL;
                $accClose_record->CHECKER = null;
                $accClose_record->USERRQ = auth()->user()->id;
                $accClose_record->HOTBOOK = $request->data['speedBookFee_option'];
                $accClose_record->PAYFOR = $request->data['PAYFOR_CODE'];
                $accClose_record->MEMO1 = $request->data['Note_CloseAC'];

                $accClose_record->REXP_PRD = $patchCon_data->EXP_PRD;
                $accClose_record->EXP_FRM = $patchCon_data->EXP_FRM;
                $accClose_record->EXP_TO = $patchCon_data->EXP_TO;
                $accClose_record->EXP_AMT = floatval($patchCon_data->EXP_AMT);
                $accClose_record->TOTBAL = floatval($request->data['_tonbalance'] == NULL ? 0.00 : str_replace(",", "", $request->data['_tonbalance']));

                // หาดอกเบี้ยทั้งหมด
                $_profbal = floatval($request->data['_intkangtotal'] == NULL ? 0.00 : str_replace(",", "", $request->data['_intkangtotal'])) +
                    floatval($request->data['_payintkang'] == NULL ? 0.00 : str_replace(",", "", $request->data['_payintkang']));
                // PROFBAL ดอกเบี้ยที่ลดแล้ว
                $accClose_record->PROFBAL = $_profbal - floatval($request->data['discount_value'] == NULL ? 0.00 : str_replace(",", "", $request->data['discount_value']));

                $accClose_record->KANGINT = floatval($request->data['_int_late_amt'] == NULL ? 0.00 : str_replace(",", "", $request->data['_int_late_amt']));
                $accClose_record->KANGOTH = floatval($request->data['_other'] == NULL ? 0.00 : str_replace(",", "", $request->data['_other']));
                $accClose_record->KANGFOLL = floatval($request->data['_letter'] == NULL ? 0.00 : str_replace(",", "", $request->data['_letter']));

                $accClose_record->TOTALKANG = $accClose_record->KANGINT + $accClose_record->KANGOTH + $accClose_record->KANGFOLL;
                $accClose_record->DISCT = floatval($request->data['discount_value'] == NULL ? 0.00 : str_replace(",", "", $request->data['discount_value']));
                $accClose_record->EXPRESSAMT = floatval($request->data['speedBookFee_value'] == NULL ? 0.00 : str_replace(",", "", $request->data['speedBookFee_value']));

                // ยอดรวมที่ต้องชำระ
                $accClose_record->PAYAMT = floatval($request->data['summary'] == NULL ? 0.00 : str_replace(",", "", $request->data['summary']));

                $accClose_record->EXPDATE = $paymentDueDate;
                if ($request->data['codeloan'] == 1) { // เงินกู้
                    $accClose_record->VATBALANCE = 0.00;
                } else {
                    //----------------------------------------
                    // หา VAX คงเหลือ = VAX ทั้งหมด - VAX ที่จ่าย
                    $vax_total = $patchPaydue->sum('damt_v');
                    $vax_pay = $patchPaydue->sum('payment_v');
                    //----------------------------------------
                    $accClose_record->VATBALANCE = $vax_total - $vax_pay;
                }
                //------------------------------
                // p_nopay งวดสุดท้ายที่จ่ายมา
                $p_nopay = $patchPaydue->where('payment', '<', 'damt')
                    ->sortBy('ddate')
                    ->first();
                //------------------------------
                // rq_due งวดที่ขอปิดบัญชี อิงตามระยะเวลาที่มาขอจ่าย
                $rq_due = $patchPaydue->where('ddate', '>=', $paymentDueDate)
                    ->sortBy('ddate')
                    ->first();
                if ($rq_due == null) {
                    $rq_due = $patchPaydue->sortByDesc('ddate')->first();
                }
                //------------------------------
                $accClose_record->T_NOPAY = $patchCon_data->T_NOPAY;
                $accClose_record->P_NOPAY = $p_nopay->nopay;
                $accClose_record->RQNOPAY = $rq_due->nopay;
                $accClose_record->UserInsert = auth()->user()->name;
                $accClose_record->UserBranch = auth()->user()->branch;
                $accClose_record->UserZone = auth()->user()->zone;
                $accClose_record->USERID = auth()->user()->id;

                // INTKANGTOTAL = ดอกเบี้ยคงเหลือ
                $accClose_record->INTKANGTOTAL = floatval($request->data['_intkangtotal'] == NULL ? 0.00 : str_replace(",", "", $request->data['_intkangtotal']));
                // ส่วนลดดอกเบี้ย %
                $accClose_record->DSCPERCEN = floatval($request->data['_dscpercen'] == NULL ? 0.00 : str_replace(",", "", $request->data['_dscpercen']));
                // PAYINTKANG = ดอกเบี้ยคงค้าง
                $accClose_record->PAYINTKANG = floatval($request->data['_payintkang'] == NULL ? 0.00 : str_replace(",", "", $request->data['_payintkang']));
                // ส่วนลดเพิ่มเติม
                $accClose_record->DISCT_EX = floatval($request->data['discount_extra_value'] == NULL ? 0.00 : str_replace(",", "", $request->data['discount_extra_value']));

                //dd($accClose_record);
                $accClose_record->save();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
            return response()->json(['message' => 'success', 'itemid' => $accClose_record->id]);
        } elseif ($request->page == 'save-invoice') {
            $contract = $this->dataContract($request->CODLOAN, $request->PatchCon_id);
            $runBill = $this->runBillINVOICE($contract, date('Y-m-d'));
            DB::beginTransaction();
            try {
                event(new EventPayments('UpdateStatINV', 'DeleteINV', $request->PatchCon_id));
                $dataTMP = TMP_INVOICE::Create([
                    'DataCus_id' => $request->DataCus_id,
                    'PactCon_id' => $request->PactCon_id,
                    'DOCNO' => $runBill,
                    'PatchCon_id' => $request->PatchCon_id,
                    'CODLOAN' => $request->CODLOAN,
                    'DATENOPAY' => $request->DATENOPAY,
                    'CONTNO' => $contract->CONTNO,
                    'LOCAT' => $request->LOCAT,
                    'EXP_FRM' => $request->EXP_FRM,
                    'EXP_TO' => $request->EXP_TO,
                    'DOCDATE' => $request->DOCDATE,
                    'TOTALPAYMENTS' => $request->TOTALPAYMENTS,
                    'PERIODDEBT' => $request->PERIODDEBT,
                    'INTLATEAMT' => $request->INTLATEAMT,
                    'FOLLOWAMT' => $request->FOLLOWAMT,
                    'DEBTOTH' => $request->DEBTOTH + $request->DISCAROTH,
                    'IDAROTH' => $request->IDAROTH,
                    'DISCAROTH' => $request->DISCAROTH,
                    'TOTOTH' => $request->DEBTOTH,
                    'INPUTPAY' => $request->INPUTPAY,
                    'DEPCASH' => $request->DEPCASH,
                    'HOLDCASH' => $request->HOLDCASH,
                    'TOTPAY' => $request->TOTPAY,
                    'PAYAMT' => $request->PAYAMT,
                    'B_INTAMT' => $request->B_INTAMT,
                    'PAYFOLLOW' => $request->PAYFOLLOW,
                    'TOTBLC' => $request->TOTBLCOTH, // ยอดหลังหักลูกหนี้อื่น
                    'PAYOTH' => $request->PAYOTH,
                    'HOLDCASHNEXT' => $request->HOLDCASHNEXT,
                    'DSCINT' => $request->DSCINT,
                    'DSCPAYFL' => $request->DSCPAYFL,
                    'OUTSBL' => $request->OUTSBL,
                    'PAYFOR_CODE' => $request->PAYFOR_CODE,
                    'PAYFOR_NAME' => $request->PAYFOR_NAME,
                    'DISCCLOSESYS' => $request->DISCCLOSESYS,
                    'DISCCLOSEAC' => $request->DISCCLOSEAC,
                    'NETBALANCE' => $request->NETBALANCE,
                    'CAPITALBLVAL' => $request->CAPITALBLVAL,
                    'userInsert' => auth()->user()->id,
                    'UserZone' => auth()->user()->zone,

                ]);

                DB::commit();
                $id_invoice = $dataTMP->id;
                // dd($id_invoice);
                $data = TMP_INVOICE::where('PactCon_id', $request->PactCon_id)->get();
                $html = view('backend.content-payments.section-create.history-invoice', compact('data'))->render();
                return response()->json(['html' => $html, 'TOTBLC' => $dataTMP->TOTBLC, 'id' => $dataTMP->id], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        } elseif ($request->page == 'save-paymentInvoice') {
            $reportArr = [];
            $TMP_INVOICE = TMP_INVOICE::find($request->id_invoice);
            if ($TMP_INVOICE->CODLOAN == 1) {
                $contractINV = $TMP_INVOICE->ContractPSL;
            } else {
                $contractINV = $TMP_INVOICE->ContractHP;
            }
            // dd($request->arrPay);
            $paramPayment = [
                'PAYAMT' => str_replace([","], "", @$TMP_INVOICE->PAYAMT),
                'PAYINT' => str_replace([","], "", @$TMP_INVOICE->B_INTAMT),
                'DSCINT' => str_replace([","], "", @$TMP_INVOICE->DSCINT),
                'DSCPAYFL' => str_replace([","], "", @$TMP_INVOICE->DSCPAYFL),
                'payfollow' => str_replace([","], "", @$TMP_INVOICE->PAYFOLLOW),
                'BILLDT' => @$TMP_INVOICE->DATENOPAY,
                'PAYTYP' => @$request->data['PAYTYP'],
                'PAYFOR' => @$request->data['PAYFOR'],
                'CHQDT' => @$request->data['CHQDT'] != NULL ? date('Y-m-d', strtotime(@$request->data['CHQDT'])) : NULL,
                'sumPay' => str_replace([","], " ", $TMP_INVOICE->TOTBLC),
                'PAYINACC' => @$request->data['PAYINACC'],
                'FLAG' => 'H',
                'INPDT' => date('Y-m-d'),
                'LOCATREC' => auth()->user()->UserToBranch->id,
                'TYPEPAY' => 'Payment',
                'UserInsert' => auth()->user()->id,
                'UserBranch' => auth()->user()->branch,
                'UserZone' => auth()->user()->zone,
            ];

            $paramPayother = [
                'PAYAMT' => str_replace([","], "", @$TMP_INVOICE->DEBTOTH),
                'BILLDT' => @$TMP_INVOICE->DATENOPAY,
                'PAYTYP' => @$request->data['PAYTYP'],
                'PAYFOR' => @$request->data['PAYFOR'],
                'CHQDT' => @$request->data['CHQDT'] != NULL ? date('Y-m-d', strtotime(@$request->data['CHQDT'])) : NULL,
                'sumPay' => str_replace([","], " ", $TMP_INVOICE->TOTOTH),
                'PAYINACC' => @$request->data['PAYINACC'],
                'FLAG' => 'H',
                'INPDT' => date('Y-m-d'),
                'LOCATREC' => auth()->user()->UserToBranch->id,
                'TYPEPAY' => 'Payother',
                'arrPay' => $request->arrPay,
                'UserInsert' => auth()->user()->id,
                'UserBranch' => auth()->user()->branch,
                'UserZone' => auth()->user()->zone,
            ];

            // dd($paramPayment, $paramPayother);
            DB::beginTransaction();
            try {
                // payment
                $BillnoPay = $this->runBill($contract, $TMP_INVOICE->DATENOPAY, 'DUE');
                session()->put('Billno_payment', $BillnoPay);

                $ses_CHQMas = $this->store_CHQMas($paramPayment, $contract, $BillnoPay);
                $ses_CHQTran = $this->store_CHQTran($paramPayment, $contract, $ses_CHQMas, $BillnoPay);
                $reportArr[] = $ses_CHQMas->id;

                if ($ses_CHQTran) {
                    $payAmt_Foll = floatval(@$paramPayment['PAYAMT']) + floatval(@$paramPayment['payfollow']);
                    if ($paramPayment['TYPEPAY'] == 'Payment') {
                        if ($contract->CODLOAN == 1) {
                            if ($contract->CONTTYP == 1) {
                                foreach (session()->get('updateDue_' . $contract->id . '/' . $contract->CODLOAN) as $key => $value) {
                                    $DuePayt = PatchPSL_DUEPAYMENT::where('id', $value['id'])->update([
                                        'PAYAMT' => $value['payamt'],
                                        'PAYINTEFF' => $value['payinteff'],
                                        'PAYTON' => $value['payton'],
                                        'PAYFOLLOW' => $value['payfollow'],
                                        'PAYDATE' => date('Y-m-d'),
                                    ]);
                                }
                                $statement = DB::statement("EXEC dbo.sp_CaloverdueCpsl ?,?,?", [date('Y-m-d'), $contract->CONTNO, $contract->LOCAT]);
                            } elseif ($contract->CONTTYP == 2) {
                                $statement = DB::statement("EXEC dbo.sp_PrePaymentLand ?,?,?,?,?", [$BillnoPay, $contract->CONTNO, $contract->LOCAT, date('Y-m-d'), $payAmt_Foll]);
                            } elseif ($contract->CONTTYP == 3) {
                                $statement = DB::statement("EXEC dbo.sp_PrePaymentShort ?,?,?,?,?", [$BillnoPay, $contract->CONTNO, $contract->LOCAT, date('Y-m-d'), $payAmt_Foll]);
                            }
                        } elseif ($contract->CODLOAN == 2) {
                            $statement = DB::statement("EXEC dbo.sp_PrePaymentHp ?,?,?,?,?", [$BillnoPay, $contract->CONTNO, $contract->LOCAT, date('Y-m-d'), $payAmt_Foll]);
                        }
                    }
                }

                // payother
                $BillnoPayother = $this->runBill($contract, $request->DATENOPAY, 'OTH');
                session()->put('Billno_payOther', $BillnoPayother);

                if (@$TMP_INVOICE->IDAROTH != NULL) { // ถ้าไม่มีใบแจ้งหนี้
                    $ses_CHQMas = $this->store_CHQMas($paramPayother, $contract, $BillnoPayother);
                    $ses_CHQTran = $this->store_CHQTran($paramPayother, $contract, $ses_CHQMas, $BillnoPayother);
                }

                DB::commit();
                event(new EventPayments('UpdateStatINV', 'UpStatINV', $contract->id));
                if (@$request->data['PAYFOR'] == '007') {
                    event(new EventPayments('UpdateContract', 'UpdatePayfor', $contract));
                }

                $reportArr[] = $ses_CHQMas->id;
                session()->put('reportArr', $reportArr);
                $active_memo = false; //show memo
                $active_table = 'd-none'; //show sum tabble

                $dataPaydue = $this->CalUpDuePayment($contract->CODLOAN, $contract->CONTTYP, $contract->CONTNO, $contract->LOCAT, date('Y-m-d'), $contract);
                $Paydue = $dataPaydue['Paydue'];
                $priceCus = $dataPaydue['priceCus']; //ยอดชำระทั้งหมด (ในตาราง)
                $intamtCus = $dataPaydue['intamtCus']; //ยอดเบี้ยปรับล่าช้าทั้งหมด (ในตาราง)
                $vfollowCus = $dataPaydue['vfollowCus']; //ยอดค่าทวงถามทั้งหมด (ในตาราง)

                // call data contract
                $contract = $this->dataContract($contract->CODLOAN, $contract->id);
                // session()->put('contract', $contract);

                // รัน ขาดงวด
                $message = 'ชำระค่างวด เรียบร้อย ';
                if ($contract->CODLOAN == 1) {
                    $viewCon = view('components.content-contract.backend.card-contracts', compact('contract', 'active_memo'))->render();
                    $viewData = view('backend.content-payments.section-view.view-tb-duepay', compact('contract', 'Paydue', 'active_table'))->render();
                } elseif ($contract->CODLOAN == 2) {
                    $viewCon = view('components.content-contract.backend.card-contracts', compact('contract', 'active_memo'))->render();
                    $viewData = view('backend.content-payments.section-view.view-tb-duepay-2', compact('contract', 'Paydue', 'active_table'))->render();
                }


                return response()->json(['html' => $viewData, 'viewCon' => $viewCon, 'DateSer' => $DateSer, 'CHQMas_id' => $ses_CHQMas->id, 'priceCus' => $priceCus, 'intamtCus' => $intamtCus, 'vfollowCus' => $vfollowCus, 'message' => $message, 'reportArr' => $reportArr, 'code' => 200]);
            } catch (\Exception $e) {
                DB::rollback();

                session()->forget('data_CHQMas');
                session()->forget('data_CHQTran');
                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->fun == 'update-ask') {        // ขอยกเลิก
            if ($request->CODLOAN == 1) {
                $affect = PatchPSL_CHQMas::where('id', $id)->update([
                    'ASK_FLAG' => 'N',
                    'ASK_DT' => date('Y-m-d H:i:s'),
                    'ASK_USERID' => auth()->user()->id,
                ]);
            } else {
                $affect = PatchHP_CHQMas::where('id', $id)->update([
                    'ASK_FLAG' => 'N',
                    'ASK_DT' => date('Y-m-d H:i:s'),
                    'ASK_USERID' => auth()->user()->id,
                ]);
            }

            if ($affect > 0) {
                return response()->json(array('user' => auth()->user()->name, 'datetime' => date('Y-m-d H:i:s'), 'message' => 'success'));
            } else {
                return response()->json(array('message' => 'failed'));
            }
        } elseif ($request->fun == 'cancel-ask') {  //ยกเลิกขอ
            if ($request->CODLOAN == 1) {
                $affect = PatchPSL_CHQMas::where('id', $id)->update([
                    'ASK_FLAG' => NULL,
                    'ASK_DT' => NULL,
                    'ASK_USERID' => NULL,
                ]);
            } else {
                $affect = PatchHP_CHQMas::where('id', $id)->update([
                    'ASK_FLAG' => NULL,
                    'ASK_DT' => NULL,
                    'ASK_USERID' => NULL,
                ]);
            }

            if ($affect > 0) {
                return response()->json(array('user' => auth()->user()->name, 'datetime' => date('Y-m-d H:i:s'), 'message' => 'success'));
            } else {
                return response()->json(array('message' => 'failed'));
            }
        } elseif ($request->fun == 'cancel-pay') {  //ยกเลิกใบเสร็จชำระ
            if ($request->typePay == 'Psl') {
                $affect = PatchPSL_CHQMas::where('id', $id)->where('ASK_FLAG', 'N')->first();
            } else {
                $affect = PatchHP_CHQMas::where('id', $id)->where('ASK_FLAG', 'N')->first();
            }

            if ($affect) {
                $affect->FLAG = 'C';
                $affect->ASK_FLAG = 'Y';
                $affect->CANDT = date('Y-m-d H:i:s');
                $affect->CAN_USERID = auth()->user()->id;
                $affect->update();

                $affect->delete();

                $message = 'success';
            } else {
                $message = 'failed';
            }

            return response()->json(array('message' => $message));
        }
    }

    // private function CalPastDueUpPay($contract, $pr_tdate)
    // {
    //     $tb_SPDEBT = TB_SPDEBT::whereMonth('month_debt', $contract->ContractToSPASTDUE->LAST_ASSIGNDT)->first();
    //     DB::select("SELECT dbo.Sp_CalPastDueUpPay(?,?,?,?,?)", [$tb_SPDEBT->f_date, $pr_tdate, $tb_SPDEBT->l_date, $contract->CONTNO, $contract->LOCAT]);
    // }

    private function query_AROTHR($typCont, $cont)
    {
        $data = ($typCont == 1) ? PatchPSL_AROTHR::where('id') : PatchHP_AROTHR::where('id');
        $dataPay = collect($data)->groupBy('PAYFOR')->all();
        return $dataPay;
    }

    private function dataContract($typCont, $id)
    {
        $contract = ($typCont == 1) ? PatchPSL_Contracts::find($id) : PatchHP_Contracts::find($id);
        return $contract;
    }

    private function inPutPay($typCont, $conttyp, $cont, $locat, $dateDue, $inputPay)
    {
        if ($typCont == 1) {
            if ($conttyp == 1) { //รถยนต์
                $Results = DB::select("SELECT * FROM dbo.utf_UpDateDuePsl(?,?,?,?)", [$cont, $locat, $dateDue, $inputPay]);
            } elseif ($conttyp == 2) { //ที่ดิน
                $Results = DB::select("SELECT * FROM dbo.utf_UpDateDueLand(?,?,?,?)", [$cont, $locat, $dateDue, $inputPay]);
            } elseif ($conttyp == 3) { //ระยะสั้น
                $Results = DB::select("SELECT * FROM dbo.utf_UpDateDueShortPSL(?,?,?,?)", [$cont, $locat, $dateDue, $inputPay]);
            }

            $Paydue = json_decode(json_encode($Results), true);
        } else {
            $Results = DB::select("SELECT * FROM dbo.utf_UpDateDueHP(?,?,?,?)", [$cont, $locat, $dateDue, $inputPay]);
            $Paydue = json_decode(json_encode($Results), true);
        }
        return array('Paydue' => $Paydue, 'Results' => $Results);
    }


    private function construct()
    {
        $data = DB::Select('SELECT CAST( GETDATE() AS DATE) as date');
        $dateServ = json_decode(json_encode($data), true);

        return $dateServ[0]['date'];
    }

    private function resetSession_alll($patchCont_id = null, $codloan = null)
    {
        session()->forget('contract');

        session()->forget('payment');
        session()->forget('Billno');
        session()->forget('flag_pt');

        session()->forget('data_CHQMas');
        session()->forget('data_CHQTran');

        session()->forget('otp_' . $patchCont_id . '/' . $codloan);     //reset otp
    }

    private function SessionPayments()
    {
        session()->forget('payment');
        session()->forget('Billno');
    }

    private function SessionCalints($contract, $dateDue)
    {
        $key = 'Calints_' . $contract->id . '_' . $contract->CODLOAN . '/' . $dateDue;

        if (!Cache::has($key)) {
            $allCacheKeys = Cache::get('all_cache_keys', collect());
            $keysToRemove = $allCacheKeys->filter(function ($cacheKey) use ($contract) {
                return strpos($cacheKey, 'Calints_' . $contract->id . '_' . $contract->CODLOAN . '/') === 0;
            });

            foreach ($keysToRemove as $oldKey) {
                Cache::forget($oldKey);
            }

            // เรียกใช้ฟังก์ชัน Calints เพื่อคำนวณข้อมูล
            $Calints = $this->Calints($contract->CODLOAN, $contract->CONTTYP, $contract->CONTNO, $contract->LOCAT, $dateDue);
            Cache::put($key, $Calints, Carbon::now()->addMinutes(3));

            // อัปเดตรายการคีย์ทั้งหมด
            $updatedCacheKeys = $allCacheKeys->reject(function ($cacheKey) use ($keysToRemove) {
                return $keysToRemove->contains($cacheKey);
            })->push($key);

            Cache::put('all_cache_keys', $updatedCacheKeys, Carbon::now()->addMinutes(3));
        }
    }
}
