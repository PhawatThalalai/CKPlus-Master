<?php

namespace App\Traits;

use Mavinoo\Batch\BatchFacade as Batch;

use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_paydue;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_paydueLoan;
use DB;
use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_CHQMas;
use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_DUEPAYMENT;
use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_CHQTran;

use App\Models\TB_PatchContracts\TB_Payments\PatchHP\PatchHP_CHQMas;
use App\Models\TB_PatchContracts\TB_Payments\PatchHP\PatchHP_CHQTran;

use App\Models\TB_Constants\TB_Backend\TB_PAYFOR;

trait PaymentsRequests
{
    /**
     * Store CHQMas data
     *
     * @param array $data
     * @param mixed $contract
     * @param string $Billno
     * @return \App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_CHQMas|\App\Models\TB_PatchContracts\TB_Payments\PatchHP\PatchHP_CHQMas
     */

    public function store_CHQMas($data, $contract, $Billno)
    {
        if ($contract->CODLOAN == 1) {
            $CHQMas = new PatchPSL_CHQMas;
            $CHQMas->PatchCon_id = $contract->id;
            $CHQMas->CONTNO = $contract->CONTNO;
            $CHQMas->BILLNO = $Billno;
            $CHQMas->BILLDT = date('Y-m-d'); //วันที่ชำระ
            $CHQMas->PAYTYP = @$data['PAYTYP'];
            // $CHQMas->PAYFOR = $data['PAYFOR'];
            $CHQMas->CHQDT = @$data['CHQDT'];
            $CHQMas->CHQAMT = @$data['sumPay'];
            // $CHQMas->CHQDISINT = @$data['CHQDISINT'];        //ส่วนลดรวม
            $CHQMas->PAYINACC = @$data['PAYINACC'];
            $CHQMas->PAYDT = @$data['BILLDT'];
            $CHQMas->CHQTMP = @$data['sumPay'];
            $CHQMas->FLAG = @$data['FLAG'];
            $CHQMas->INPDT = @$data['INPDT'];
            $CHQMas->LOCATREC = @$data['LOCATREC'];
            $CHQMas->LOCATPAY = @$contract->LOCAT;
            $CHQMas->TYPEPAY = @$data['TYPEPAY'];
            $CHQMas->UserInsert = auth()->user()->id;
            $CHQMas->UserBranch = auth()->user()->branch;
            $CHQMas->UserZone = auth()->user()->zone;
            $CHQMas->save();

        } elseif ($contract->CODLOAN == 2) {
            $CHQMas = new PatchHP_CHQMas;
            $CHQMas->PatchCon_id = $contract->id;
            $CHQMas->CONTNO = $contract->CONTNO;
            $CHQMas->BILLNO = $Billno;
            $CHQMas->BILLDT = date('Y-m-d');                 //วันที่ชำระ
            $CHQMas->PAYTYP = @$data['PAYTYP'];
            // $CHQMas->PAYFOR = $data['PAYFOR'];
            $CHQMas->CHQDT = @$data['CHQDT'];
            $CHQMas->CHQAMT = @$data['sumPay'];
            // $CHQMas->CHQDISINT = @$data['CHQDISINT'];        //ส่วนลดรวม
            $CHQMas->PAYINACC = @$data['PAYINACC'];
            $CHQMas->PAYDT = @$data['BILLDT'];
            $CHQMas->CHQTMP = @$data['sumPay'];
            $CHQMas->FLAG = @$data['FLAG'];
            $CHQMas->INPDT = @$data['INPDT'];
            $CHQMas->LOCATREC = @$data['LOCATREC'];
            $CHQMas->LOCATPAY = @$contract->LOCAT;
            $CHQMas->TYPEPAY = @$data['TYPEPAY'];
            $CHQMas->UserInsert = auth()->user()->id;
            $CHQMas->UserBranch = auth()->user()->branch;
            $CHQMas->UserZone = auth()->user()->zone;
            $CHQMas->save();
        }

        return $CHQMas;
    }

    public function store_CHQTran($data, $contract, $CHQMas, $Billno)
    {
        $TotalPAYAMT = ($data['PAYAMT']);

        if ($contract->CODLOAN == 1) {
            // $PayTonInteff = session()->get('PayTonInteff');
            if ($data['TYPEPAY'] == 'Payment') {
                $distPlus = ((@$data['DSCINT'] == NULL) ? 0 : @$data['DSCINT']) + ((@$data['DSCPAYFL'] == NULL) ? 0 : @$data['DSCPAYFL']);
                $PayTonInteff = $this->payton_inteff($contract, $data['BILLDT'], $data['sumPay'] + (@$data['DISCT'] != NULL ? @$data['DISCT'] : 0) + $distPlus, $contract->CONTTYP);

                $payAmt_Foll = floatval($data['PAYAMT']) + floatval($data['payfollow']);
                $ctFpay = PatchPSL_CHQTran::where('CONTNO', $contract->CONTNO)->max('F_PAY') + 1; //006/007
                $CHQTran = new PatchPSL_CHQTran;
                $CHQTran->PatchCon_id = $contract->id;
                $CHQTran->CONTNO = $contract->CONTNO;
                $CHQTran->ChqMas_id = $CHQMas->id;

                $CHQTran->TMBILL = $Billno;
                $CHQTran->TMBILDT = date('Y-m-d'); //วันที่ชำระ
                $CHQTran->PAYTYP = @$data['PAYTYP'];
                $CHQTran->PAYFOR = @$data['PAYFOR'];
                $CHQTran->PAYDT = @$data['BILLDT'];

                $CHQTran->PAYAMT = @$data['PAYAMT'];
                $CHQTran->DISCT = @$data['DISCT'] != NULL ? @$data['DISCT'] : 0;

                $CHQTran->PAYINT = ((@$data['PAYINT'] == NULL) ? 0 : @$data['PAYINT']);
                $CHQTran->DSCINT = ((@$data['DSCINT'] == NULL) ? 0 : @$data['DSCINT']); //ค่าปรับ

                $CHQTran->NETPAY = @$data['sumPay'];
                $CHQTran->NEXTCAPITAL = (@$PayTonInteff[0]['nextcapital'] == NULL ? 0 : @$PayTonInteff[0]['nextcapital']);
                $CHQTran->TON_BALANCE = (@$PayTonInteff[0]['tonbalance'] == NULL ? 0 : @$PayTonInteff[0]['tonbalance']);
                $CHQTran->LPAYAMT = @$contract->LPAYA;
                $CHQTran->LPAYDT = @$contract->LPAYD;

                $CHQTran->NOPAY = @$PayTonInteff[0]['nopay'];
                $CHQTran->F_PAR = @$PayTonInteff[0]['f_par'];
                $CHQTran->F_PAY = @$PayTonInteff[0]['f_pay'];
                $CHQTran->L_PAR = @$PayTonInteff[0]['l_par'];
                $CHQTran->L_PAY = @$PayTonInteff[0]['l_pay'];

                $CHQTran->PAYAMT_N = (@$PayTonInteff[0]['payton'] == NULL ? 0 : @$PayTonInteff[0]['payton']);
                $CHQTran->PAYAMT_V = (@$PayTonInteff[0]['payinteff'] == NULL ? 0 : @$PayTonInteff[0]['payinteff']);

                $CHQTran->PAYINDUE = (@$PayTonInteff[0]['s_Due']);
                $CHQTran->PAYFL = @$data['payfollow'];
                $CHQTran->DSCPAYFL = ((@$data['DSCPAYFL'] == NULL) ? 0 : @$data['DSCPAYFL']);
                $CHQTran->Memo = @$data['Memo'];

                $CHQTran->FLAG = 'H';
                $CHQTran->INPDT = date('Y-m-d');
                $CHQTran->LOCATPAY = $contract->LOCAT;
                $CHQTran->LOCATREC = auth()->user()->branch;

                $CHQTran->UserInsert = auth()->user()->id;
                $CHQTran->UserBranch = auth()->user()->branch;
                $CHQTran->UserZone = auth()->user()->zone;
                $CHQTran->save();


                // if (!empty($CHQTran) && !empty(session()->get('updateDue_' . $contract->id . '/' . $contract->CODLOAN))) {
                //     if ($contract->CONTTYP == 1) {
                //         foreach (session()->get('updateDue_' . $contract->id . '/' . $contract->CODLOAN) as $key => $value) {
                //             $DuePayt = PatchPSL_DUEPAYMENT::where('id', $value['id'])->update([
                //                 'PAYAMT' => $value['payamt'],
                //                 'PAYINTEFF' => $value['payinteff'],
                //                 'PAYTON' => $value['payton'],
                //                 'PAYFOLLOW' => $value['payfollow'],
                //                 'PAYDATE' => date('Y-m-d'),
                //             ]);
                //         }
                //         $statement = DB::statement("EXEC dbo.sp_CaloverdueCpsl ?,?,?", [date('Y-m-d'), $contract->CONTNO, $contract->LOCAT]);
                //     } elseif ($contract->CONTTYP == 2) {
                //         $statement = DB::statement("EXEC dbo.sp_PrePaymentLand ?,?,?,?,?", [$Billno, $contract->CONTNO, $contract->LOCAT, $CHQTran->PAYDT, $payAmt_Foll]);
                //     } elseif ($contract->CONTTYP == 3) {
                //         $statement = DB::statement("EXEC dbo.sp_PrePaymentShort ?,?,?,?,?", [$Billno, $contract->CONTNO, $contract->LOCAT, $CHQTran->PAYDT, $payAmt_Foll]);
                //     }
                // }
            } else {
                //loop กรณีเป็นลูกหนี้อื่น วนตาม รหัสชำระ
                foreach (@$data['arrPay'] as $key1 => $payfor) {
                    foreach ($payfor as $key2 => $item) {
                        $CHQTran = new PatchPSL_CHQTran;
                        $CHQTran->PatchCon_id = $contract->id;
                        $CHQTran->CONTNO = $contract->CONTNO;
                        $CHQTran->ChqMas_id = $CHQMas->id;
                        $CHQTran->AR_id = $item['id'];

                        $CHQTran->TMBILL = $Billno;
                        $CHQTran->TMBILDT = date('Y-m-d');               //วันที่ชำระ
                        $CHQTran->PAYTYP = @$data['PAYTYP'];                //ชำระโดย
                        $CHQTran->PAYFOR = $key1;                          //เปลี่ยนตาม loop
                        $CHQTran->PAYDT = @$data['BILLDT'];                 //วันที่ชำระ

                        $CHQTran->PAYAMT = (min($TotalPAYAMT, $item['payamt'])) + (($item['dicint'] == NULL) ? 0 : $item['dicint']);  //จำนวนเงินที่จ่าย
                        ($TotalPAYAMT -= $item['payamt']);

                        if ($item == end($payfor)) {
                            $CHQTran->DISCT = ((@$item['dicint'] == NULL) ? 0 : $item['dicint']);   //ส่วนลด
                        }

                        $CHQTran->NETPAY = ($CHQTran->PAYAMT - $CHQTran->DISCT);    //สุทธิ
                        $CHQTran->FLAG = 'H';
                        $CHQTran->INPDT = date('Y-m-d');
                        $CHQTran->LOCATPAY = $contract->LOCAT;
                        $CHQTran->LOCATREC = auth()->user()->branch;
                        $CHQTran->Memo = @$data['Memo'];

                        $CHQTran->UserInsert = auth()->user()->id;
                        $CHQTran->UserBranch = auth()->user()->branch;
                        $CHQTran->UserZone = auth()->user()->zone;
                        $CHQTran->save();
                    }
                }
            }
        } elseif ($contract->CODLOAN == 2) {
            $payAmt_Foll = floatval(@$data['PAYAMT']) + floatval(@$data['payfollow']);
            if ($data['TYPEPAY'] == 'Payment') {
                $CHQTran = new PatchHP_CHQTran;
                $CHQTran->PatchCon_id = $contract->id;
                $CHQTran->CONTNO = $contract->CONTNO;
                $CHQTran->ChqMas_id = $CHQMas->id;

                $CHQTran->TMBILL = $Billno;
                $CHQTran->TMBILDT = date('Y-m-d'); //วันที่ชำระ
                $CHQTran->PAYTYP = @$data['PAYTYP'];
                $CHQTran->PAYFOR = @$data['PAYFOR']; //เปลี่ยนตาม loop
                $CHQTran->PAYDT = @$data['BILLDT'];
                $CHQTran->PAYAMT = @$data['PAYAMT'];
                // $CHQTran->DISCT = ((@$DSCINT == NULL) ? 0 : $DSCINT);
                $CHQTran->DISCT = @$data['DISCT'] != NULL ? @$data['DISCT'] : 0;

                $CHQTran->PAYINT = ((@$data['PAYINT'] == NULL) ? 0 : @$data['PAYINT']);
                $CHQTran->DSCINT = ((@$data['DSCINT'] == NULL) ? 0 : @$data['DSCINT']);

                $CHQTran->PAYFL = @$data['payfollow'];
                $CHQTran->DSCPAYFL = ((@$data['DSCPAYFL'] == NULL) ? 0 : @$data['DSCPAYFL']);

                $CHQTran->NETPAY = @$data['sumPay'];
                $CHQTran->PAYAMT_N = @$data['PAYAMT'];
                $CHQTran->PAYINDUE = "Due";

                $CHQTran->PAYAMT_V = 0;
                $CHQTran->F_PAY = '';
                $CHQTran->FLAG = 'H';
                $CHQTran->INPDT = date('Y-m-d');
                $CHQTran->LOCATPAY = $contract->LOCAT;
                $CHQTran->LOCATREC = auth()->user()->branch;
                $CHQTran->Memo = @$data['Memo'];

                $CHQTran->UserInsert = auth()->user()->id;
                $CHQTran->UserBranch = auth()->user()->branch;
                $CHQTran->UserZone = auth()->user()->zone;
                $CHQTran->save();


                // if($CHQTran->save()){
                //     $statement = DB::statement("EXEC dbo.sp_PrePaymentHp ?,?,?,?,?", [$Billno, $contract->CONTNO, $contract->LOCAT, $CHQTran->PAYDT, $payAmt_Foll]);
                // }
            } else {
                //loop กรณีเป็นลูกหนี้อื่น วนตาม รหัสชำระ
                foreach (@$data['arrPay'] as $key1 => $payfor) {
                    foreach ($payfor as $key2 => $item) {
                        $CHQTran = new PatchHP_CHQTran;
                        $CHQTran->PatchCon_id = $contract->id;
                        $CHQTran->CONTNO = $contract->CONTNO;
                        $CHQTran->ChqMas_id = $CHQMas->id;
                        $CHQTran->AR_id = $item['id'];
                        $CHQTran->TMBILL = $Billno;
                        $CHQTran->TMBILDT = date('Y-m-d'); //วันที่ชำระ
                        $CHQTran->PAYTYP = @$data['PAYTYP']; //ชำระโดย
                        $CHQTran->PAYFOR = $key1; //เปลี่ยนตาม loop
                        $CHQTran->PAYDT = @$data['BILLDT'];

                        $CHQTran->PAYAMT = (min($TotalPAYAMT, $item['payamt'])) + (($item['dicint'] == NULL) ? 0 : $item['dicint']);  //จำนวนเงินที่จ่าย
                        ($TotalPAYAMT -= $item['payamt']);

                        if ($item == end($payfor)) {
                            $CHQTran->DISCT = ((@$item['dicint'] == NULL) ? 0 : @$item['dicint']);
                        }

                        $CHQTran->NETPAY = ($CHQTran->PAYAMT - $CHQTran->DISCT);    //สุทธิ
                        $CHQTran->FLAG = 'H';
                        $CHQTran->INPDT = date('Y-m-d');
                        $CHQTran->LOCATPAY = $contract->LOCAT;
                        $CHQTran->LOCATREC = auth()->user()->branch;
                        $CHQTran->Memo = @$data['Memo'];

                        $CHQTran->UserInsert = auth()->user()->id;
                        $CHQTran->UserBranch = auth()->user()->branch;
                        $CHQTran->UserZone = auth()->user()->zone;
                        $CHQTran->save();
                    }
                }
            }
        }

        return $CHQTran;
    }

    public function CalUpDuePayment($typCont, $conttyp, $cont, $locat, $dateDue, $contract)
    {
        $Paydue = [];
        if ($typCont == 1) {
            $queryType = [
                1 => 'dbo.utf_CalUpDuePsl',
                2 => 'dbo.utf_CalUpDueLand',
                3 => 'dbo.utf_CalupDueShortPSL',
            ];

            $query = "SELECT * FROM " . $queryType[$conttyp] . "(?,?,?)";
            $Results = DB::select($query, [$cont, $locat, $dateDue]);
            $Paydue = json_decode(json_encode($Results), true);
            $intamt = collect($Paydue)->sum('INTLATEAMT') ?? 0;
        } elseif ($typCont == 2) {
            $Results = DB::select("SELECT * FROM dbo.utf_CalupDueHP(?,?,?)", [$cont, $locat, $dateDue]);
            $Paydue = json_decode(json_encode($Results), true);

            $intamt = collect($Paydue)->sum('intamt') ?? 0;
        }

        // คำนวณผลรวมของแต่ละคอลัมน์
        $pricedue = collect($Paydue)->sum('dueamt') ?? 0;
        $paydue = collect($Paydue)->sum('payamt') ?? 0;
        $vfollow = collect($Paydue)->sum('followamt') ?? 0;
        $payfollow = collect($Paydue)->sum('payfollow') ?? 0;

        // ตรวจสอบว่ามีข้อมูลใน $Paydue หรือไม่
        if ($conttyp == 1 && $typCont == 1) {
            if (!empty($Paydue)) {
                $priceCus = ($pricedue + $intamt) + ($vfollow - $payfollow) - $paydue;
            } else {
                $priceCus = $contract->CAPITALBL + $intamt + ($vfollow - $payfollow);
            }
        } else {
            $priceCus = ($contract->TOTPRC - $contract->SMPAY) + $intamt + ($vfollow - $payfollow);
        }

        return ['Paydue' => $Paydue, 'priceCus' => $priceCus, 'intamtCus' => $intamt, 'vfollowCus' => ($vfollow - $payfollow)];
    }

    public function enableCheckpayfor($Aroth)
    {
        $payfor = TB_PAYFOR::where('STATUSREG', 'Y')->pluck('FORCODE')->toArray();
        $StatPayOther = $Aroth->whereIn('PAYFOR', $payfor)->isEmpty() ? 'false' : 'true';
        $StatPayOther_N = $Aroth->whereNotIn('PAYFOR', $payfor)->isEmpty() ? 'false' : 'true';

        return [
            'StatPayOther' => $StatPayOther,
            'StatPayOther_N' => $StatPayOther_N,
        ];
    }

    // รันเลขที่เอกสาร ใบเสร็จรับเงิน
    private function runBill($contract, $BILLDT, $tx_header)
    {
        // $locatpay = auth()->user()->UserToBranch->id_Contract;
        $locatpay = auth()->user()->branch;
        $billFunction = ($contract->CODLOAN == 1) ? 'dbo.uft_runbillno' : 'dbo.uft_runbillnoHP';
        $dataBill = DB::select("SELECT $billFunction (?,?,?,?,?)", [$locatpay, $contract->UserZone, $contract->LOCAT, $BILLDT, $tx_header]);
        $Billno = json_decode(json_encode($dataBill), true)[0][''];

        return $Billno;
    }

    // รันเลขที่เอกสาร ใบแจ้งหนี้
    private function runBillINVOICE($contract, $BILLDT)
    {
        $locatpay = auth()->user()->UserToBranch->id_Contract;
        $dataBill = DB::select("SELECT dbo.uft_runbillInv(?,?,?,?,?)", [($contract->TYPECON), $contract->UserZone, $contract->LOCAT, $BILLDT, 'INV-']);
        $Billno = json_decode(json_encode($dataBill), true)[0][''];

        return $Billno;
    }

    // รันเลขที่เอกสาร บันทึกขอปิดบัญชี
    private function runCloseBill($contract, $BILLDT)
    {
        $billFunction = ($contract->CODLOAN == 1) ? 'dbo.uft_runclosebillPSL' : 'dbo.uft_runclosebillHP';
        $dataBill = DB::select("SELECT $billFunction(?,?,?,?,?)", [$contract->TYPECON, $contract->UserZone, $contract->LOCAT, $BILLDT, 'CLA-']);
        $Billno = json_decode(json_encode($dataBill), true)[0][''];

        return $Billno;
    }

    /**
     * บันทึกขอปิดบัญชี ใช้คำนวณ ดอกเบี้ย ค้างค่าปรับ จนถึงวันที่ชำระ
     *
     * @param string    $codloan        ประเภทสัญญาหลัก  (1 เงินกู้, 2 เช่าซื้อ)
     * @param string    $conttyp        ประเภทสัญญา  (1 เงินกู้, 2 เช่าซื้อ, 3 เงินกู้ผ่อนแต่ดอก)
     * @param string    $contno         เลขที่สัญญา
     * @param string    $locat          ไอดีสาขา
     * @param string    $dateDuePay     กำหนดชำระถึงวันที่
     * @return array<string, mixed>     ดอกเบี้ย ค้างค่าปรับ
     */
    private function calCloseAC($codloan, $typCont, $contno, $locat, $dateDuePay)
    {
        if ($codloan == 1) {
            if ($typCont == 1) {
                // ส่วนลดเงินกู้ ลด 100%
                $Results = DB::select("SELECT * FROM dbo.utf_CalupClosePsl(?,?,?)", [$contno, $locat, $dateDuePay]);
            } elseif ($typCont == 2) {
                // ที่ดิน ปิดบัญชีคิดส่วนลด 50%
                $Results = DB::select("SELECT * FROM dbo.utf_CalupCloseLand(?,?,?,?)", [$contno, $locat, $dateDuePay, 0]);
            } elseif ($typCont == 3) {
                // ขายฝาก จำนอง
                // เพิ่มลูกหนี้อื่น
                $Results = DB::select("SELECT CAPITALBL AS tonbalance, (TOTPRC-CAPITALBL)-SMPAY AS payintkang, 0 AS intlateday, 0 AS INTLATEAMT ,'" . $dateDuePay . "' as paydate  FROM PatchPSL_Contracts WHERE contno = '" . $contno . "'");
            }

        } elseif ($codloan == 2) {
            $Results = DB::select("SELECT * FROM dbo.utf_CalupCloseHP(?,?,?,?)", [$contno, $locat, $dateDuePay, 0]);
        }
        //$calCloseAC = json_decode(json_encode($Results), true);
        // tonbalance   เงินต้นคงเหลือ
        // intlateday   จำนวนวันคิดดอก
        // payintkang   ดอกเบี้ยคงค้าง
        // intkangtotal ดอกเบี้ยคงเหลือ
        // INTLATEAMT   ค้างค่าปรับ
        return $Results[0];
    }

    private function Calints($typCont, $conttyp, $cont, $locat, $dateDue)
    {
        // $queryTypePSL = [
        //     1 => 'EXEC dbo.Sp_Calintpsl',
        //     2 => 'EXEC dbo.Sp_CalintShortPSL',
        //     3 => 'EXEC dbo.Sp_CalintShortPSL',
        // ];
        // $queryTypeHP = [
        //     1 => 'EXEC dbo.Sp_Calinthp',
        // ];

        // $procedureName = $conttyp;
        // if ($typCont == 1) {
        //     $statement = DB::statement("{$queryTypePSL[$procedureName]} ?,?,?", [$cont, $locat, $dateDue]);
        // } else {
        //     $statement = DB::statement("{$queryTypeHP[$procedureName]} ?,?,?", [$cont, $locat, $dateDue]);
        // }
        // return $statement;

        if ($typCont == 1) {
            if ($conttyp == 1) { //รถยนต์
                $data = DB::select("SELECT * FROM dbo.uft_Calintpsl(?,?,?)", [$cont, $locat, $dateDue]);
                $dataPaydue = PatchPSL_DUEPAYMENT::select('id', 'CONTNO', 'NOPAY', 'INTLATEAMT', 'INTLATEDAY')
                    ->where("CONTNO", $cont)
                    ->whereColumn('DUEAMT', '<>', 'LASTPAYAMT')
                    ->orderBy('NOPAY', 'asc')
                    ->get()
                    ->toArray();

                $nopayList = array_column($dataPaydue, 'NOPAY');
                $idMap = array_column($dataPaydue, 'id', 'NOPAY');

                $updateData = collect($data)->filter(function ($dataItem) use ($nopayList) {
                    return in_array($dataItem->nopay, $nopayList);
                })->map(function ($dataItem) use ($idMap) {
                    $id = $idMap[$dataItem->nopay] ?? null;
                    return $id ? [
                        'id' => $id,
                        'INTLATEAMT' => floatval($dataItem->intamt),
                        'INTLATEDAY' => intval($dataItem->delayday)
                    ] : null;
                })->filter()->values()->all();

                Batch::update(new PatchPSL_DUEPAYMENT(), $updateData, 'id');
            } else {
                $data = DB::select("SELECT * FROM dbo.uft_CalintShortPSL(?,?,?)", [$cont, $locat, $dateDue]);
                $dataPaydue = PatchPSL_paydueLoan::select('id', 'contno', 'nopay', 'intamt', 'delayday')
                    ->where("contno", $cont)
                    ->whereColumn('damt', '<>', 'payment')
                    ->orderBy('nopay', 'asc')
                    ->get()
                    ->toArray();

                $nopayList = array_column($dataPaydue, 'nopay');
                $idMap = array_column($dataPaydue, 'id', 'nopay');

                $updateData = collect($data)->filter(function ($dataItem) use ($nopayList) {
                    return in_array($dataItem->nopay, $nopayList);
                })->map(function ($dataItem) use ($idMap) {
                    $id = $idMap[$dataItem->nopay] ?? null;
                    return $id ? [
                        'id' => $id,
                        'intamt' => floatval($dataItem->intamt),
                        'delayday' => intval($dataItem->delayday)
                    ] : null;
                })->filter()->values()->all();

                Batch::update(new PatchPSL_paydueLoan(), $updateData, 'id');
            }
        } else {
            $data = DB::select("SELECT * FROM dbo.uft_Calinthp(?,?,?)", [$cont, $locat, $dateDue]);
            $dataPaydue = PatchHP_paydue::select('id', 'contno', 'nopay', 'intamt', 'delayday')
                ->where("contno", $cont)
                ->whereColumn('damt', '<>', 'payment')
                ->orderBy('nopay', 'asc')
                ->get()
                ->toArray();

            $nopayList = array_column($dataPaydue, 'nopay');
            $idMap = array_column($dataPaydue, 'id', 'nopay');

            $updateData = collect($data)->filter(function ($dataItem) use ($nopayList) {
                return in_array($dataItem->nopay, $nopayList);
            })->map(function ($dataItem) use ($idMap) {
                $id = $idMap[$dataItem->nopay] ?? null;
                return $id ? [
                    'id' => $id,
                    'intamt' => floatval($dataItem->intamt),
                    'delayday' => intval($dataItem->delayday)
                ] : null;
            })->filter()->values()->all();

            Batch::update(new PatchHP_paydue(), $updateData, 'id');
        }

        return true;
    }


    private function payton_inteff($contract, $dateDue, $inputPay, $conttyp)
    {
        if ($contract->CODLOAN == 1) {
            if ($conttyp == 1) { //รถยนต์
                $data = DB::select("SELECT * FROM dbo.utf_PrePayment(?,?,?,?)", [$contract->CONTNO, $contract->LOCAT, $dateDue, $inputPay]);
            } elseif ($conttyp == 2) {
                $data = DB::select("SELECT * FROM dbo.utf_PrePaymentLand(?,?,?,?)", [$contract->CONTNO, $contract->LOCAT, $dateDue, $inputPay]);
            } elseif ($conttyp == 3) {
                $data = DB::select("SELECT * FROM dbo.utf_PrePaymentShort(?,?,?,?)", [$contract->CONTNO, $contract->LOCAT, $dateDue, $inputPay]);
            }

            $setvalue = json_decode(json_encode($data), true);

        } else {
            $data = DB::select("SELECT * FROM dbo.utf_PrePaymentHP(?,?,?,?)", [$contract->CONTNO, $contract->LOCAT, $dateDue, $inputPay]);
            $setvalue = json_decode(json_encode($data), true);
        }

        return $setvalue;
    }
    private function paymentAmt($locat, $cont, $nopay, $capbl, $lpay, $dpay, $irr, $payment)
    {
        $data = DB::select("SELECT * FROM dbo.utf_PaymentAmt(?,?,?,?,?,?,?,?,?,?)", [$locat, $cont, $nopay, $capbl, $lpay, $dpay, ($irr), $payment, 0, 0]);
        $setvalue = json_decode(json_encode($data), true);

        return $setvalue;
    }

    private function minimumPaydue($dataPaydue, $contract)
    {
        $totalIntAmt = 0;
        $totalFollow = 0;
        $minPay = $contract->ContractToSPASTDUE->MinPay ?? $contract->TOT_UPAY;

        $result = array_filter($dataPaydue, function ($payment) use (&$minPay, &$totalIntAmt, &$totalFollow, $contract) {
            $dueamt = floatval($payment["dueamt"]);
            $valid = $minPay > 0;
            if ($valid) {
                $minPay -= $dueamt;
                $totalIntAmt += floatval($contract->CODLOAN == 1 ? $payment["INTLATEAMT"] : $payment["intamt"]);
                $totalFollow += (floatval($payment["followamt"]) - floatval($payment["payfollow"]));
            }

            return $valid;
        });

        return compact('result', 'totalIntAmt', 'totalFollow');
    }

}
