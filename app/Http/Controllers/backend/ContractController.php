<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;
use Hash;
use PDF;
use Barryvdh\DomPDF\Facade\Pdf as domPDF;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_Constants\TB_Frontend\TB_TypeLoan;
use App\Models\TB_Constants\TB_Frontend\TB_TypeCalculateInt;
use App\Models\TB_Constants\TB_Frontend\TB_Company;

use App\Models\TB_Constants\TB_Backend\TB_CONFPSL;
use App\Models\TB_Constants\TB_Backend\TB_CONFHP;

use App\Models\TB_DataCus\Data_Customer;
use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_Contracts;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_paydue;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_Contracts;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_paydue;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_paydueLoan;

use App\Models\TB_Configs\TB_ConfigsInside\TB_SETGRADE;

use App\Models\TB_PatchContracts\TB_Payments\PacthPSL\PacthPSL_CHQMas;
use App\Models\TB_PatchContracts\TB_Payments\PacthPSL\PacthPSL_CHQTran;
use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_HDPAYMENT;
use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_CHQMas;
use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_CHQTran;
use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_DUEPAYMENT;

use App\Models\TB_PatchContracts\TB_Payments\PatchHP\PatchHP_CHQMas;
use App\Models\TB_PatchContracts\TB_Payments\PatchHP\PatchHP_CHQTran;
use App\Models\TB_PatchContracts\TB_Payments\PatchHP\PatchHP_DUEPAYMENT;


class ContractController extends Controller
{
    public static function query($user_zone, $newfdate, $newtdate, $id)
    {
        $query = Pact_Contracts::leftJoin('Data_Customers', function ($join) {
            $join->on('Pact_Contracts.DataCus_id', '=', 'Data_Customers.id');
        })
            ->leftJoin('TB_TypeLoans', function ($join) {
                $join->on('TB_TypeLoans.Loan_Code', '=', 'Pact_Contracts.CodeLoan_Con');
            })
            ->where('Pact_Contracts.UserZone', $user_zone)
            ->where('Pact_Contracts.Date_monetary', '!=', NULL)
            ->when(!empty($id), function ($q) use ($id) {
                return $q->where('Pact_Contracts.UserBranch', $id);
            })
            ->where(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"), '>', '2023-12-31')
            ->when(!empty($newfdate) && !empty($newtdate), function ($q) use ($newfdate, $newtdate) {
                return $q->whereBetween('Pact_Contracts.Date_monetary', [$newfdate, $newtdate])
                    ->whereBetween(DB::raw(" FORMAT (cast(Pact_Contracts.Date_monetary as date), 'yyyy-MM-dd')"), [$newfdate, $newtdate]);

            })
            ->selectRaw("Pact_Contracts.Flag_Inside, Pact_Contracts.id, Pact_Contracts.Contract_Con, Pact_Contracts.CodeLoan_Con, Pact_Contracts.BranchSent_Con,TB_TypeLoans.Loan_Name, Pact_Contracts.Date_monetary, Data_Customers.Name_Cus, Pact_Contracts.DateDue_Con");

        return $query;
    }

    public function index(Request $request)
    {
        if ($request->page == 'edit-contract') {
            /*** set value search */
            $page_type = 'backend';
            $page = $request->page;
            $pageUrl = 'mega-edit-con';
            $typeSreach = 'contract';
            $dataSreach = [
                'namecus' => true,
                'idcardcus' => true,
                'license' => true,
                'contract' => true,
            ];
            $hideSearchTopbar = true;

            return view('backend.topbar-mega-menu.view-editContract', compact('page_type', 'page', 'pageUrl', 'typeSreach', 'dataSreach', 'hideSearchTopbar'));
        }
    }

    public function edit(Request $request, $id)
    {
        $page = $request->page;
        if ($request->page == 'contract') {
            $pact = Pact_Contracts::where('id', $id)->first();
            if ($pact->ContractToTypeLoan->Loan_Com == 1) { //เงินกู้
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
            } else { //เช่าซื้อ
                $PatchCon_id = $pact->ContractToConHP->id;
                $contract = PatchHP_Contracts::where('DataPact_id', $pact->id)
                    ->with('ContractCHQMaspay')
                    ->first();

            }
            return view(
                'backend.content-contract.view-contract',
                compact(
                    'pact',
                    'contract',
                    'page'
                )
            );
        } elseif ($request->page == 'edit-contract') {
            $pageUrl = 'mega-edit-con';
            $pact = Pact_Contracts::where('id', $id)->first();
            if ($pact->ContractToTypeLoan->Loan_Com == 1) { //เงินกู้
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
            } else { //เช่าซื้อ
                $PatchCon_id = $pact->ContractToConHP->id;
                $contract = PatchHP_Contracts::where('DataPact_id', $pact->id)
                    ->with('ContractCHQMaspay')
                    ->first();
            }

            return view(
                'backend.topbar-mega-menu.view-editContract',
                compact(
                    'pact',
                    'contract',
                    'pageUrl',
                    'page'
                )
            );
        } elseif ($request->page == 'viewContract') { // หน้าดูสัญญา (หน้าสัญญาในเมนูด้านซ้ายที่ไปทุกหน้า) (ของท็อป)
            if ($request->funs == 'edit') { // แก้ไขสัญญา
                //เช่าซื้อ
                //$data = PatchHP_Contracts::where('id', $request->id)->first();
                $pact = Pact_Contracts::where('id', $id)->first();

                $contract = null;
                if ($request->CODLOAN == 1) { // เงินกู้
                    $contract = $pact->ContractToConPSL;
                } elseif ($request->CODLOAN == 2) { // เช่าซื้อ
                    $contract = $pact->ContractToConHP;
                }
                return view('backend.content-contract.section-edit.edit-contract', compact('pact', 'contract', 'page'));
            }
        }
    }

    public function store(Request $request)
    {
        if ($request->type == 1) {
            //dd($request);
            $loanCode = ['08', '09', '10', '18', '16'];
            $SUBCONTNO = substr($request->CONTNO, 4, 2);

            if ($request->Loan_Com == 1) {
                DB::beginTransaction();
                try {
                    $totPrc = floatval(str_replace(array(',', '_'), "", @$request->TOTPRC)) - floatval(str_replace(array(',', '_'), "", @$request->TOTDAWN));
                    $tonbl = floatval(str_replace(array(',', '_'), "", @$request->TCSHPRC));
                    $netprofit = $totPrc - $tonbl;

                    $data = new PatchPSL_Contracts;
                    $data->DataCus_id = $request->DataCus_id;
                    $data->DataTag_id = $request->DataTag_id;
                    $data->DataPact_id = $request->DataPact_id;
                    // $data->DataAsset_id = $request->DataAsset_id;
                    $data->CONTNO = $request->CONTNO;
                    $data->CODLOAN = $request->Loan_Com; //ประเภทสัญญา เงินกู้  = 1
                    $data->CONTTYP = $request->CONTTYP; //ประเภทสัญญา 1 = เงินกู้ปกติ  /  2 = ที่ดิน 04,15 / 3 = ระยะสั้น
                    $data->TYPECON = $request->CodeLoan_Con; //ประเภทสัญญา 01 02 ..
                    $data->TOTPRC = floatval(str_replace(array(',', '_'), "", @$request->TOTPRC)); //ราคาขายผ่อน
                    $data->SDATE = $request->SDATE; //วันทำสัญญา
                    $data->FDATE = $request->FDATE; //วันดิวงวดแรก
                    $data->DLDAY = $request->DLDAY; //วันล่าช้าไม่เกิน
                    $data->INTLATE = floatval($request->INTLATE); //เบี้ยปรับล่าช้า
                    $data->NETPROFIT = floatval($netprofit); // ดอกเบี้ยทั้งสัญญา
                    $data->TCSHPRC = floatval(str_replace(array(',', '_'), "", @$request->TCSHPRC)); //เงินต้นกู้ยืม
                    $data->CAPITALBL = floatval(str_replace(array(',', '_'), "", @$request->TCSHPRC)); //เงินต้นกู้ยืม
                    $data->INTFLATRATE = floatval($request->INTFLATRATE); //ดอกเบี้ย flat rate
                    $data->Interest_IRR = floatval($request->Interest_IRR); //ดอกเบี้ย irr
                    $data->PERIOD = $request->PERIOD; //ผ่อนต่อเดือน(ครั้ง)
                    $data->TOT_UPAY = floatval(str_replace(array(',', '_'), "", @$request->TOT_UPAY)); //งวดละ(บาท)
                    $data->T_NOPAY = $request->T_NOPAY; //จำนวนงวดทั้งหมด
                    $data->APPLICANT = $request->APPLICANT; //ผู้ขออนุมัติ
                    $data->LDATE = $request->LDATE; //ดิวงวดสุดท้าย
                    $data->LOCAT = $request->LOCAT; //สาขาสัญญา
                    $data->LPAYD = @$request->FDATEINT;
                    $data->FDATEINT = @$request->FDATEINT; //วันที่คิดดอกเบี้ย
                    $data->BALANC = floatval(str_replace(array(',', '_'), "", @$request->TOTPRC)); //ยอดคงเหลือ
                    $data->LASTDUEDATE = @$request->FDATEINT;
                    $data->TONBALANCE = floatval(str_replace(array(',', '_'), "", @$request->TCSHPRC));
                    $data->CONTSTAT = 'N';
                    $data->GRDCOD = 'A';
                    $data->BILLCOLL = $request->LOCAT;
                    $data->SALECOD = $request->SALECOD;
                    $data->BARCODENO = @$request->CONTNO;
                    // $data->LOANCON = $SUBCONTNO;
                    $data->MTHDDIS = $request->MTHDDIS;//วิธีคำนวณส่วนลดตัดสด
                    $data->USEADD = $request->USEADD;
                    $data->UserZone = auth()->user()->zone;
                    $data->UserBranch = auth()->user()->branch;
                    $data->UserInsert = auth()->user()->id;
                    $data->Id_Com = $request->Id_Com;
                    $data->save();

                    if ($request->CONTTYP == 3) {
                        $Paydue = DB::select("SELECT * FROM dbo.uft_addduelan(?,?,?,?,?,?,?,?,?,?,?,?)", [
                            $data->LOCAT,
                            $data->CONTNO,
                            $data->T_NOPAY,
                            $data->TOT_UPAY,
                            (floatval($data->TOT_UPAY) + floatval($data->TCSHPRC)),
                            $data->PERIOD,
                            $data->SDATE,
                            $data->FDATE,
                            $data->TOTPRC,
                            $data->TCSHPRC,
                            $data->INTLATE,
                            floatval($data->Interest_IRR)
                        ]);
                    } else if ($request->CONTTYP == 2) {

                        $Paydue = DB::select(
                            "SELECT * FROM dbo.uft_adddueland(?,?,?,?,?,?,?,?,?)",
                            [$data->LOCAT, $data->CONTNO, $data->T_NOPAY, $data->TOT_UPAY, $data->PERIOD, $data->FDATEINT, $data->FDATE, (($data->Interest_IRR)), $data->TCSHPRC]
                        );

                    } else {

                        $Paydue = DB::select(
                            "SELECT * FROM dbo.uft_adddueplone(?,?,?,?,?,?,?,?,?)",
                            [
                                $data->LOCAT,
                                $data->CONTNO,
                                $data->T_NOPAY,
                                $data->TOT_UPAY,
                                $data->PERIOD,
                                $data->FDATEINT,
                                $data->FDATE,
                                (($data->Interest_IRR * 12) / 100), //new  (($data->Interest_IRR ) / 100),
                                $data->TCSHPRC
                            ]
                        );
                    }

                    foreach ($Paydue as $key => $value) {
                        if ($request->CONTTYP == 3 || $request->CONTTYP == 2) {
                            $item = new PatchPSL_paydueLoan; //เงินกู้ที่ดิน + เงินกู้ระยะสั้น
                        } else {
                            $item = new PatchPSL_paydue; // เงินกู้ปกติ
                        }
                        $item->PatchCon_id = $data->id;
                        $item->contno = $value->contno;
                        $item->locat = $value->locat;
                        $item->nopay = $value->nopay;
                        $item->ddate = $value->ddate;
                        $item->damt = $value->damt;
                        $item->capital = $value->capital;
                        $item->interest = $value->interest;
                        $item->irr = $value->irr;
                        $item->capitalbl = $value->capitalbl;
                        $item->daycalint = $value->daycalint;
                        $item->save();
                    }


                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response(['error' => true, 'status' => $e->getMessage()], 500);
                }
                if (!in_array($SUBCONTNO, $loanCode)) {

                    // เปิดตอนจะรัน dueจริง
                    // // $getPost = DB::connection("sqlsrv")->statement("EXEC dbo.sp_CrtFTDuePayment '" . $data->FDATE . "','" . $data->CONTNO . "'");

                    // $splitTdate = explode('-',date('Y-m-d'));
                    // $HBill = "D".substr( $splitTdate[0],2,2).$splitTdate[1].$splitTdate[2];

                    // DB::select("INSERT INTO PatchPSL_DUEPAYMENT (
                    //     PatchCon_id, Paydue_id, CONTNO, LOCAT, TMBILL, NOPAY, TONBALANCE, LASTDUEDT,
                    //     DUEDATE, DUEAMT, DUEINTEFF, DUETONEFF, LASTPAYAMT, LASTPAYDT, PAYDATE, DELAYDAY,
                    //     DAYCALINT, INTEFFR, PAYAMT, PAYINTEFF, PAYTON, PAYINTKANG, INTLATEDAY, INTLATERT,
                    //     INTLATEAMT, LETTERINT, FOLLOWAMT, PAYFOLLOW, NEXTCAPITAL, NEXTINTKANG, SMPAYINTKANG,
                    //     FLAGAR, USERID, INPUTDATE)
                    // SELECT
                    //     a.PatchCon_id,
                    //     a.id,
                    //     TRIM(a.contno),
                    //     a.locat,
                    //     '".$HBill."' + dbo.uft_ZeroLead(ROW_NUMBER() OVER (ORDER BY a.ddate) +
                    //         (SELECT CASE WHEN MAX(TMBILL) IS NOT NULL THEN CAST(SUBSTRING(MAX(TMBILL), 8, 5) AS INT) ELSE 0 END
                    //         FROM PatchPSL_DUEPAYMENT
                    //         WHERE SUBSTRING(TMBILL, 1, 7) = '".$HBill."'), 6) AS tmbill,
                    //     a.nopay,
                    //     a.capitalbl,
                    //     CAST(FORMAT(DATEADD(MONTH, -1, a.ddate), 'yyyy-MM-dd') AS DATE) AS lastdue,
                    //     CAST(FORMAT(a.ddate, 'yyyy-MM-dd') AS DATE) AS due,
                    //     a.damt,
                    //     a.interest,
                    //     a.capital,
                    //     0,
                    //     NULL,
                    //     NULL,
                    //     ISNULL(a.delayday, 0),
                    //     ISNULL(a.daycalint, 0),
                    //     a.interest,
                    //     0,
                    //     0,
                    //     0,
                    //     0 AS PAYINTKANG,
                    //     0,
                    //     0.25 AS INTLATERT,
                    //     ISNULL(intamt, 0),
                    //     0 AS LETTERINT,
                    //     0 AS FOLLOWAMT,
                    //     0 AS PAYFOLLOW,
                    //     capitalbl AS NEXTCAPITAL,
                    //     0 AS NEXTINTKANG,
                    //     0 AS SMPAYINTKANG,
                    //     'N' AS FLAGAR,
                    //     '' AS USERID,
                    //     GETDATE() AS INPUTDATE
                    // FROM PatchPSL_paydue a
                    // LEFT JOIN PatchPSL_DUEPAYMENT b ON a.contno = b.CONTNO
                    // WHERE b.CONTNO IS NULL AND a.contno = '".$data->CONTNO."'
                    // ORDER BY a.contno, a.nopay;
                    // ");

                    //     DB::select("update PatchPSL_paydue set date1 = ddate  where date1 is null and id = id and contno ='" . $data->CONTNO . "'");

                }

                if ($request->CONTTYP == 3 || $request->CONTTYP == 2) {
                    $overdueLand = DB::connection("sqlsrv")->statement("EXEC dbo.sp_CaloverdueCLoan '" . date('Y-m-d') . "','" . $data->CONTNO . "','" . $data->LOCAT . "'");
                } else {
                    $overduePSL = DB::connection("sqlsrv")->statement("EXEC dbo.sp_CaloverdueCpsl '" . date('Y-m-d') . "','" . $data->CONTNO . "','" . $data->LOCAT . "'");
                }
                $createFTInvioce = DB::connection("sqlsrv")->statement("EXEC dbo.sp_CrtInvoiceFt '" . $data->FDATE . "','" . $data->CONTNO . "'");
            } else {
                DB::beginTransaction();
                try {
                    $data = new PatchHP_Contracts;
                    $data->DataCus_id = $request->DataCus_id;
                    $data->DataTag_id = $request->DataTag_id;
                    $data->DataPact_id = $request->DataPact_id;
                    // $data->DataAsset_id = $request->DataAsset_id;

                    $data->CONTNO = $request->CONTNO;
                    $data->CODLOAN = $request->Loan_Com; //ประเภทสัญญา เช่าซื้อ  = 2
                    $data->CONTTYP = $request->CONTTYP; //ประเภทสัญญา 1 = เช่าซื้อปกติ
                    $data->TYPECON = $request->CodeLoan_Con; //ประเภทสัญญา 01 02 ..
                    $data->TOTPRC = floatval(str_replace(array(',', '_'), "", @$request->TOTPRC)); //ราคาขายผ่อน
                    $data->SDATE = $request->SDATE; //วันทำสัญญา
                    $data->FDATE = $request->FDATE; //วันดิวงวดแรก
                    $data->DLDAY = $request->DLDAY; //วันล่าช้าไม่เกิน
                    $data->INTLATE = $request->INTLATE; //เบี้ยปรับล่าช้า

                    $data->VCSHPRC = ($request->VCSHPRC != NULL ? floatval(str_replace(array(',', '_'), "", @$request->VCSHPRC)) : 0.00); //ภาษีเงินต้น
                    $data->NCSHPRC = ($request->NCSHPRC != NULL ? floatval(str_replace(array(',', '_'), "", @$request->NCSHPRC)) : 0.00); //เงินต้นกู้ยืมไม่รวมภาษี
                    $data->TCSHPRC = ($request->TCSHPRC != NULL ? floatval(str_replace(array(',', '_'), "", @$request->TCSHPRC)) : 0.00); //เงินต้นกู้ยืม
                    $data->INTFLATRATE = floatval($request->INTFLATRATE); //ดอกเบี้ย flat rate
                    $data->Interest_IRR = floatval($request->Interest_IRR); //ดอกเบี้ย irr
                    $data->PERIOD = floatval($request->PERIOD); //ผ่อนต่อเดือน(ครั้ง)
                    $data->VATRT = floatval($request->VATRT); //VAT
                    $data->TOT_UPAY = floatval(str_replace(array(',', '_'), "", @$request->TOT_UPAY)); //งวดละ(บาท)
                    $data->T_NOPAY = $request->T_NOPAY; //จำนวนงวดทั้งหมด
                    $data->APPLICANT = $request->APPLICANT; //ผู้ขออนุมัติ
                    $data->LDATE = $request->LDATE; //ดิวงวดสุดท้าย
                    $data->LOCAT = $request->LOCAT; //สาขาสัญญา
                    $data->LPAYD = @$request->FDATEINT;
                    $data->FDATEINT = @$request->FDATEINT; //วันที่คิดดอกเบี้ย
                    $data->BALANC = floatval(str_replace(array(',', '_'), "", @$request->TOTPRC)); //ยอดคงเหลือ

                    $data->VATDAWN = ($request->VATDAWN != NULL ? floatval(str_replace(array(',', '_'), "", @$request->VATDAWN)) : 0.00); //ภาษีเงินดาวน์
                    $data->NDAWN = ($request->NDAWN != NULL ? floatval(str_replace(array(',', '_'), "", @$request->NDAWN)) : 0.00); //เงินดาวน์ไม่รวมภาษี
                    $data->TOTDAWN = ($request->TOTDAWN != NULL ? floatval(str_replace(array(',', '_'), "", @$request->TOTDAWN)) : 0.00);
                    $data->SMPAY = ($request->TOTDAWN != NULL ? floatval(str_replace(array(',', '_'), "", @$request->TOTDAWN)) : 0.00);
                    $data->CONTSTAT = 'N';
                    $data->GRDCOD = 'A';
                    $data->SALECOD = $request->SALECOD;
                    $data->BARCODENO = @$request->CONTNO;
                    // $data->LOANCON = $SUBCONTNO;
                    $data->BILLCOLL = $request->LOCAT;
                    $data->MTHDDIS = $request->MTHDDIS;
                    $data->USEADD = $request->USEADD;
                    $data->UserZone = auth()->user()->zone;
                    $data->UserBranch = auth()->user()->branch;
                    $data->UserInsert = auth()->user()->id;
                    $data->Id_Com = $request->Id_Com;
                    $data->save();

                    //ต้นไม่รวมดาวน์
                    // dd($data->LOCAT,$data->CONTNO,$data->T_NOPAY,$data->TOT_UPAY,$data->PERIOD,$data->SDATE,$data->FDATE,
                    // $data->Interest_IRR, $data->NCSHPRC,$data->VATRT,$data->INTLATE,$request->totinterest);

                    $Paydue = DB::select(
                        "SELECT * FROM dbo.uft_addduehp(?,?,?,?,?,?,?,?,?,?,?)",
                        [$data->LOCAT, $data->CONTNO, $data->T_NOPAY, $data->TOT_UPAY, $data->PERIOD, $data->FDATEINT, $data->FDATE, (($data->Interest_IRR)), $data->TCSHPRC, $data->VATRT, $data->INTLATE]
                    );

                    // $Paydue = DB::select(
                    //     "SELECT * FROM dbo.uft_addduehp2(?,?,?,?,?,?,?,?,?,?,?,?)",
                    //     [$data->LOCAT, $data->CONTNO, $data->T_NOPAY, $data->TOT_UPAY, $data->PERIOD, $data->FDATEINT, $data->FDATE, (($data->Interest_IRR)), $data->NCSHPRC, $data->VATRT, $data->INTLATE,$request->totinterest]
                    // ); //พิเศษ

                    // dump($data->LOCAT,$data->CONTNO,$data->T_NOPAY,$data->TOT_UPAY,$data->PERIOD,$data->SDATE,$data->FDATE,
                    // (($data->Interest_IRR/12)/100), $data->TCSHPRC,$data->VATRT,$data->INTLATE);

                    // $Paydue = DB::select("SELECT * FROM dbo.uft_addduehp(?,?,?,?,?,?,?,?,?,?,?)",
                    //     [$data->LOCAT,$data->CONTNO,$data->T_NOPAY,$data->TOT_UPAY,$data->PERIOD,$data->SDATE,$data->FDATE,
                    //     (($data->Interest_IRR/12)/100), $data->TCSHPRC,$data->VATRT,$data->INTLATE]);

                    foreach ($Paydue as $key => $value) {
                        $item = new PatchHP_paydue;
                        $item->PatchCon_id = $data->id;
                        $item->contno = $value->contno;
                        $item->locat = $value->locat;
                        $item->nopay = $value->nopay;
                        $item->ddate = $value->ddate;
                        $item->vatrt = $value->vatrt;
                        $item->damt = $value->damt;
                        $item->damt_v = $value->damt_v;
                        $item->damt_n = $value->damt_n;
                        $item->capital = $value->capital;
                        $item->interest = $value->interest;
                        $item->intrt = $value->intrt;
                        $item->capitalbl = $value->capitalbl;
                        $item->daycalint = $value->daycalint;
                        $item->save();
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response(['error' => true, 'status' => $e->getMessage()], 500);
                }

                $overdueHP = DB::connection("sqlsrv")->statement("EXEC dbo.sp_CaloverdueChp '" . date('Y-m-d') . "','" . $data->CONTNO . "','" . $data->LOCAT . "'");
                $createFTInvioce = DB::connection("sqlsrv")->statement("EXEC dbo.sp_CrtInvoiceFt '" . $data->FDATE . "','" . $data->CONTNO . "'");
            }

            $user_zone = auth()->user()->zone;
            $newfdate = @$request->newfdate;
            $newtdate = @$request->newtdate;

            $type = $request->type;
            $idUserBranch = $request->UserBranch;

            $data = static::query($user_zone, $newfdate, $newtdate, $idUserBranch)->get();
            $idNow = $request->DataPact_id;

            $returnHTML = view('backend.content-view.section-contract.data-contract', compact('data'))->render();
            return response()->json(['html' => $returnHTML, 'idNow' => $idNow]);
        }

    }

    public function update(Request $request, $id)
    {
        // บันทึกหน้าแก้ไขสัญญา
        if ($request->type == 1) {
            if ($request->CODLOAN == 1) { // สัญญาเงินกู้
                DB::beginTransaction();
                try {
                    $contract = PatchPSL_Contracts::where('id', $id)->first();
                    $contract->INTLATE = $request->data['INTLATE'];
                    $contract->DLDAY = $request->data['DLDAY'];
                    //$contract->VATRT = $request->VATRT;
                    //$contract->MAXINT = $request->MAXINT;
                    $contract->MTHDDIS = $request->data['MTHDDIS'];
                    //$contract->MTHDFINE = $request->MTHDFINE;
                    $contract->CONTSTAT = $request->data['CONTSTAT'];
                    $contract->RECONTNO = $request->data['RECONTNO'];
                    $contract->CARRDT = $request->data['CARRDT'];
                    $contract->SO = $request->data['SO'];
                    $contract->USEADD = $request->data['USEADD'];
                    //str_replace('\n', "\n", $s);
                    $contract->MEMO = $request->data['MEMO'];
                    $contract->update();

                    DB::commit();

                    $active_memo = 'true';
                    $viewCon = view('components.content-contract.backend.card-contracts', compact('contract', 'active_memo'))->render();

                    $pact = $contract->PatchToPact;
                    $page = 'contracts';
                    $viewProfile = view('components.content-user.backend.view-profile-b-end', compact('pact', 'page'))->render();

                    return response()->json(array('viewCon' => $viewCon, 'viewProfile' => $viewProfile, 'message' => 'success'));
                } catch (\Exception $e) {
                    DB::rollback();

                    $message = 'success';
                    return response()->json(['message' => $e->getMessage()], 500);
                }
            } elseif ($request->CODLOAN == 2) { // สัญญาเช่าซื้อ
                DB::beginTransaction();
                try {
                    $contract = PatchHP_Contracts::where('id', $id)->first();
                    $contract->INTLATE = $request->data['INTLATE'];
                    $contract->DLDAY = $request->data['DLDAY'];
                    $contract->VATRT = $request->data['VATRT'];
                    //$contract->MAXINT = $request->MAXINT;
                    $contract->MTHDDIS = $request->data['MTHDDIS'];
                    //$contract->MTHDFINE = $request->MTHDFINE;
                    $contract->CONTSTAT = $request->data['CONTSTAT'];
                    $contract->RECONTNO = $request->data['RECONTNO'];
                    $contract->CARRDT = $request->data['CARRDT'];
                    $contract->SO = $request->data['SO'];
                    $contract->USEADD = $request->data['USEADD'];

                    //str_replace('\n', "\n", $s);
                    $contract->MEMO = $request->data['MEMO'];
                    $contract->update();

                    DB::commit();

                    $active_memo = true;
                    $viewCon = view('components.content-contract.backend.card-contracts', compact('contract', 'active_memo'))->render();

                    $pact = $contract->PatchToPact;
                    $page = 'contracts';
                    $viewProfile = view('components.content-user.backend.view-profile-b-end', compact('pact', 'page'))->render();

                    return response()->json(array('viewCon' => $viewCon, 'viewProfile' => $viewProfile, 'message' => 'success'));
                } catch (\Exception $e) {
                    DB::rollback();

                    $message = 'success';
                    return response()->json(['message' => $e->getMessage()], 500);
                }
            }
        }
    }

    public function show(Request $request, $id)
    {
        if ($request->page == "print-contractform") {
            if ($request->form == "HP_Cus") {
                $pact = Pact_Contracts::where('id', $id)->first();
                $data = PatchHP_Contracts::where('DataPact_id', $id)->first();

                $dataComp = TB_Company::where('Company_Zone', $data->UserZone)
                    ->where('id', $data->Id_Com)
                    ->first();
                // dd($pact,$data,$dataComp);

                $type = $request->type;
                $view = \View::make('backend.content-report.PDF.FormHP-Cus', compact('data', 'dataComp', 'type'));
                $html = $view->render();
                // ob_end_clean();
                $pdf = new PDF();
                $pdf->SetTitle('ฟอร์มสัญญาเช่าซื้อรถยนต์');
                $pdf->AddPage('P', 'F4');
                $pdf->SetY(5, true, true);
                $pdf->SetMargins(5, 5, 5, 5);
                $pdf->SetFont('thsarabun', '', 12, '', true);
                $pdf->SetAutoPageBreak(TRUE, 18);
                $pdf->WriteHTML($html, true, false, true, false, '');
                $pdf->Output('FormContract.pdf');
            } else if ($request->form == "HP_Grant") {

                $pact = Pact_Contracts::where('id', $id)->first();
                $data = PatchHP_Contracts::where('DataPact_id', $id)->first();

                $dataComp = TB_Company::where('Company_Zone', $data->UserZone)
                    ->where('id', $data->Id_Com)
                    ->first();
                // dd($pact,$data,$dataComp);

                $type = $request->type;
                $view = \View::make('backend.content-report.PDF.FormHP-Grant', compact('data', 'dataComp', 'type'));
                $html = $view->render();
                // ob_end_clean();
                $pdf = new PDF();
                $pdf->SetTitle('ฟอร์มสัญญาค้ำประกันเช่าซื้อ');
                $pdf->AddPage('P', 'F4');
                $pdf->SetY(5, true, true);
                $pdf->SetMargins(5, 5, 5, 5);
                $pdf->SetFont('thsarabun', '', 12, '', true);
                $pdf->SetAutoPageBreak(TRUE, 18);
                $pdf->WriteHTML($html, true, false, true, false, '');
                $pdf->Output('FormContract.pdf');
            } else if ($request->form == "PSL_Cus") {

                $data = PatchPSL_Contracts::where('DataPact_id', $id)->first();

                $dataComp = TB_Company::where('Company_Zone', $data->UserZone)
                    ->where('id', $data->Id_Com)
                    ->first();
                // dd($dataComp);
                $type = $request->type;

                if (in_array($data->TYPECON, ['04', '10', '15', '16', '18'])) {
                    $type = $request->type;
                    $data = Pact_Contracts::where('id', $data->DataPact_id)->first();
                    $view = \View::make('frontend.content-report.PDF.Form.FormLandContractBlankNew', compact('data', 'type'));

                    $html = $view->render();

                    if (!empty($data->ContractToGuarantor)) {
                        foreach ($data->ContractToGuarantor as $guard) {
                            $view = \View::make('frontend.content-report.PDF.Form.FormLandGuardBlankNew', compact('data', 'guard', 'type'));
                            $html .= $view->render();
                        }

                    }

                    // $pdf = new PDF();
                    // $pdf::SetTitle('ใบสัญญากู้ยืม');
                    // $pdf::AddPage("P",'A4');
                    // $pdf::SetMargins(5, 5, 5, 0);
                    // $pdf::SetFont('thsarabun', '', 14, '', true);
                    // $pdf::SetAutoPageBreak(true,20);
                    // $pdf::WriteHTML($html, true, false, true, false, '');
                    // $pdf::Output('report.pdf');
                    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
                    $pdf->setPaper('a4', 'portrait');

                    return $pdf->stream();
                } else if (in_array($data->TYPECON, ['11', '12', '13', '17'])) {
                    $type = $request->type;
                    $data = Pact_Contracts::where('id', $data->DataPact_id)->first();
                    $view = \View::make('frontend.content-report.PDF.Form.FormPersonContractBlankNew', compact('data', 'type'));
                    $html = $view->render();
                    //$pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
                    if (!empty($data->ContractToGuarantor)) {
                        foreach ($data->ContractToGuarantor as $guard) {
                            $view = \View::make('frontend.content-report.PDF.Form.FormPersonGuardBlank', compact('data', 'guard', 'type'));
                            $html .= $view->render();
                        }

                    }

                    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
                    $pdf->setPaper('a4', 'portrait');

                    return $pdf->stream();
                } else {
                    $view = \View::make('backend.content-report.PDF.FormPSL-Cus', compact('data', 'dataComp', 'type'));
                    $html = $view->render();
                    // ob_end_clean();
                    $pdf = new PDF();
                    $pdf->SetTitle('ฟอร์มสัญญาเงินกู้');
                    $pdf->AddPage('P', 'F4');
                    $pdf->SetY(5, true, true);
                    $pdf->SetMargins(5, 5, 5, 5);
                    $pdf->SetFont('thsarabun', '', 12, '', true);
                    $pdf->SetAutoPageBreak(TRUE, 18);
                    $pdf->WriteHTML($html, true, false, true, false, '');
                    $pdf->Output('FormContract.pdf');

                }


            } else if ($request->form == "PSL_Grant") {
                // $pact = Pact_Contracts::where('id', $id)->first();
                // $data = PatchPSL_Contracts::where('DataPact_id', $id)->first();
                $pact = Pact_Contracts::where('id', $request->id)->first();
                $data = PatchPSL_Contracts::where('DataPact_id', $request->id)->first();

                $dataComp = TB_Company::where('Company_Zone', $data->UserZone)
                    ->where('id', $data->Id_Com)
                    ->first();
                // dd($dataComp);

                if (in_array($data->TYPECON, ['04', '10', '15', '16', '18'])) {
                    $type = $request->type;
                    $data = Pact_Contracts::where('id', $data->DataPact_id)->first();


                    if (!empty($data->ContractToGuarantor)) {
                        $html = '';
                        foreach ($data->ContractToGuarantor as $guard) {
                            $view = \View::make('frontend.content-report.PDF.Form.FormLandGuardBlankNew', compact('data', 'guard', 'type'));
                            $html .= $view->render();
                        }
                        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
                        $pdf->setPaper('a4', 'portrait');

                        return $pdf->stream();
                    }



                } else if (in_array($data->TYPECON, ['11', '12', '13', '17'])) {
                    $type = $request->type;
                    $data = Pact_Contracts::where('id', $data->DataPact_id)->first();

                    if (!empty($data->ContractToGuarantor)) {
                        $html = '';
                        foreach ($data->ContractToGuarantor as $guard) {
                            $view = \View::make('frontend.content-report.PDF.Form.FormPersonGuardBlank', compact('data', 'guard', 'type'));
                            $html .= $view->render();
                        }
                        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
                        $pdf->setPaper('a4', 'portrait');
                        return $pdf->stream();
                    }


                } else {
                    $type = $request->type;
                    $view = \View::make('backend.content-report.PDF.FormPSL-Grant', compact('data', 'dataComp', 'type'));
                    $html = $view->render();
                    // ob_end_clean();
                    $pdf = new PDF();
                    $pdf->SetTitle('ฟอร์มสัญญาค้ำประกันเงินกู้');
                    $pdf->AddPage('P', 'F4');
                    $pdf->SetY(5, true, true);
                    $pdf->SetMargins(5, 5, 5, 5);
                    $pdf->SetFont('thsarabun', '', 12, '', true);
                    $pdf->SetAutoPageBreak(TRUE, 18);
                    $pdf->WriteHTML($html, true, false, true, false, '');
                    $pdf->Output('FormContract.pdf');
                }
            } else if ($request->form == "PSL_Land") {
                $pact = Pact_Contracts::where('id', $id)->first();
                $data = PatchPSL_Contracts::where('DataPact_id', $id)->first();

                $dataComp = TB_Company::where('Company_Zone', $data->UserZone)
                    ->where('id', $data->Id_Com)
                    ->first();
                // dd($dataComp);

                $type = $request->type;
                $view = \View::make('backend.content-report.PDF.FormPSL-Land', compact('data', 'dataComp', 'type'));
                $html = $view->render();
                // ob_end_clean();
                $pdf = new PDF();
                $pdf->SetTitle('ฟอร์มสัญญาเงินกู้');
                $pdf->AddPage('P', 'F4');
                $pdf->SetY(5, true, true);
                $pdf->SetMargins(5, 5, 5, 5);
                $pdf->SetFont('thsarabun', '', 12, '', true);
                $pdf->SetAutoPageBreak(TRUE, 18);
                $pdf->WriteHTML($html, true, false, true, false, '');
                $pdf->Output('FormContract.pdf');
            }
        } elseif ($request->page == "get-contentCon") {
            $pact = Pact_Contracts::where('id', $id)->first();
            if ($pact->ContractToTypeLoan->Loan_Com == 1) { //เงินกู้
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
            } else { //เช่าซื้อ
                $PatchCon_id = $pact->ContractToConHP->id;
                $contract = PatchHP_Contracts::where('DataPact_id', $pact->id)
                    ->with('ContractCHQMaspay')
                    ->first();

            }
            if ($request->tab == "contract-details") {
                $html = view('backend.content-contract.section-content.contract-details', compact('contract'))->render();
                return response()->json(["html" => $html]);
            } elseif ($request->tab == "table-install") {
                $html = view('backend.content-contract.section-content.table-install', compact('contract'))->render();
                return response()->json(["html" => $html]);
            } elseif ($request->tab == "table-payment") {
                $html = view('backend.content-contract.section-content.table-payment', compact('contract'))->render();
                return response()->json(["html" => $html]);
            } elseif ($request->tab == "table-fee") {
                $dataTHR = DB::table('View_AROTHR')
                    ->where('PatchCon_id', $contract->id)
                    ->where('CODLOAN', $contract->CODLOAN)
                    ->get();
                $html = view('backend.content-contract.section-content.table-fee', compact('contract', 'dataTHR'))->render();
                return response()->json(["html" => $html]);
            } elseif ($request->tab == "table-deposit") {
                $html = view('backend.content-contract.section-content.table-deposit', compact('contract'))->render();
                return response()->json(["html" => $html]);
            } elseif ($request->tab == "table-installments") {
                $html = view('backend.content-contract.section-content.table-installments', compact('contract'))->render();
                return response()->json(["html" => $html]);
            } elseif ($request->tab == "data-main-asset") {
                $html = view('backend.content-contract.section-content.data-main-asset', compact('contract'))->render();
                return response()->json(["html" => $html]);
            } elseif ($request->tab == "data-main-guaran") {
                $html = view('backend.content-contract.section-content.data-main-guaran', compact('contract'))->render();
                return response()->json(["html" => $html]);
            } elseif ($request->tab == "content_contract_user") {
                $html = view('backend.content-contract.section-content.data_contract_user', compact('pact'))->render();
                return response()->json(["html" => $html]);
            } elseif ($request->tab == "content_contract") {
                /*** set value search */
                $page_type = 'backend';
                $page = $request->page;
                $pageUrl = false;
                $typeSreach = 'contract';
                $dataSreach = [
                    'namecus' => true,
                    'idcardcus' => true,
                    'license' => true,
                    'contract' => true,
                ];

                $pact = Pact_Contracts::where('id', $id)->first();
                if ($pact->ContractToTypeLoan->Loan_Com == 1) { //เงินกู้
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
                } else { //เช่าซื้อ
                    $PatchCon_id = $pact->ContractToConHP->id;
                    $contract = PatchHP_Contracts::where('DataPact_id', $pact->id)
                        ->with('ContractCHQMaspay')
                        ->first();

                }
                $html = view(
                    'backend.content-contract.section-content.contract-view',
                    compact(
                        'pact',
                        'contract',
                        'page_type',
                        'page',
                        'pageUrl',
                        'typeSreach',
                        'dataSreach'
                    )
                )->render();
                return response()->json(["html" => $html]);
            } elseif ($request->tab == "content_contract_poss") {
                $data = $pact->ContractToCus;
                $html = view('backend.content-contract.section-content.contract-poss', compact('pact', 'data', 'contract'))->render();
                return response()->json(["html" => $html]);
            } elseif ($request->tab == "data-main-contract") {
                $html = view('backend.content-contract.section-content.data-main-contract', compact('pact'))->render();
                return response()->json(["html" => $html]);
            }

        } elseif ($request->page == 'profile-content') {
            $page = $request->page;
            $pact = Pact_Contracts::where('id', $id)->first();

            $viewProfile = view('components.content-user.backend.view-profile-b-end', compact('pact', 'page'))->render();
            return response()->json(["html" => $viewProfile]);
        }
    }

    private function resetSession_all()
    {
        session()->flush();
    }

    public function destroy($id, Request $request)
    {
        $Datapac = Pact_Contracts::find($id);
        $text = '';



        if ($Datapac->ContractToTypeLoan->Loan_Com == 1) {
            $Datapatch = PatchPSL_Contracts::where('CONTNO', $Datapac->Contract_Con)->first();
        }



        if ($Datapac->ContractToTypeLoan->Loan_Com == 1) {
            $chlMas = PatchPSL_CHQMas::where('CONTNO', $Datapac->Contract_Con)->first();
            if ($chlMas == NULL) {
                PatchPSL_Contracts::where('CONTNO', $Datapac->Contract_Con)->forceDelete();
                PatchPSL_CHQMas::where('CONTNO', $Datapac->Contract_Con)->forceDelete();
                PatchPSL_CHQTran::where('CONTNO', $Datapac->Contract_Con)->forceDelete();
                if ($Datapatch->CONTTYP == '1') {
                    PatchPSL_paydue::where('CONTNO', $Datapac->Contract_Con)->forceDelete();
                    PatchPSL_DUEPAYMENT::where('CONTNO', $Datapac->Contract_Con)->forceDelete();
                } else {
                    PatchPSL_paydueLoan::where('CONTNO', $Datapac->Contract_Con)->forceDelete();
                }
                $Datapac->Flag_Inside = NULL;
                $Datapac->Date_Inside = NULL;
                $Datapac->update();
            } else {
                $text = '';
                return response(["error" => true, "message" => "ไม่สามารถลบสัญญาได้เนื่องจากมีการรับเงินในสัญญาแล้ว !"], 500);
            }


        } else {
            $chlMas = PatchHP_CHQMas::where('CONTNO', $Datapac->Contract_Con)->first();
            if ($chlMas == NULL) {
                PatchHP_Contracts::where('CONTNO', $Datapac->Contract_Con)->forceDelete();
                PatchHP_CHQMas::where('CONTNO', $Datapac->Contract_Con)->forceDelete();
                PatchHP_CHQTran::where('CONTNO', $Datapac->Contract_Con)->forceDelete();
                PatchHP_paydue::where('CONTNO', $Datapac->Contract_Con)->forceDelete();
                $Datapac->Flag_Inside = NULL;
                $Datapac->Date_Inside = NULL;
                $Datapac->update();
            } else {
                return response(["error" => true, "message" => "ไม่สามารถลบสัญญาได้เนื่องจากมีการรับเงินในสัญญาแล้ว !"], 500);

            }
        }

        $user_zone = auth()->user()->zone;
        $newfdate = @$request->newfdate;
        $newtdate = @$request->newtdate;

        $type = $request->type;
        $idUserBranch = $Datapac->BranchSent_Con;

        $data = static::query($user_zone, $newfdate, $newtdate, $idUserBranch)->get();
        $idNow = $Datapac->id;

        $returnHTML = view('backend.content-view.section-contract.data-contract', compact('data'))->render();
        return response()->json(['html' => $returnHTML, 'idNow' => $idNow, 'text' => $text]);

    }
}
