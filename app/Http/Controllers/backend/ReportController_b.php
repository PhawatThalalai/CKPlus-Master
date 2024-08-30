<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_Constants\TB_Backend\TB_PAYTYP;
use App\Models\TB_Constants\TB_Backend\TB_PAYFOR;
use App\Models\TB_Constants\TB_Backend\TB_TYPCONT;

class ReportController_b extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->type == 1) { //Report view Contracts
            $data = "svjkdfkjf";
            $type = $request->type;
            $view = \View::make('backend.content-report.PDF.FormContractHP', compact('data', 'type'));
            $html = $view->render();

            // ob_end_clean();
            // $pdf = new PDF();
            // $pdf::SetTitle('ฟอร์มสัญญาเช่าซื้อรถยนต์-ผู้เช่าซื้อ');
            // $pdf::AddPage('P', 'F4');
            // $pdf::SetY(5, true, true);
            // $pdf::SetMargins(5, 5, 5, 5);
            // $pdf::SetFont('thsarabun', '', 12, '', true);
            // $pdf::SetAutoPageBreak(TRUE, 18);
            // $pdf::WriteHTML($html,true,false,true,false,'');
            // $pdf::Output('FormContract.pdf');

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
            $pdf->setPaper('F4', 'P');
            return @$pdf->stream();
        }
    }

    public function create(Request $request)
    {
        if ($request->type == 1) { //Contract form
            $user_zone = auth()->user()->zone;
            $PactCon_id = $request->PactCon_id;
            $data = Pact_Contracts::where('id', $request->id)->first();
           

            $type = $request->type;
            $view = \View::make('frontend.content-report.PDF.reportContract', compact('data', 'type'));
            $html = $view->render();
            $pdf = new PDF();
            $pdf::SetTitle('ใบขออนุมัติสัญญา');
            $pdf::AddPage("P", 'A4');
            $pdf::SetMargins(5, 5, 5, 0);
            $pdf::SetFont('thsarabun', '', 12, '', true);
            $pdf::SetAutoPageBreak(true, 20);

            $pdf::WriteHTML($html, true, false, true, false, '');
            $pdf::Output('report.pdf');
        } elseif ($request->type == 2) { //card payment
            $user_zone = auth()->user()->zone;
            $PactCon_id = $request->PactCon_id;
            $data = Pact_Contracts::where('id', $request->id)->first();

            $ref_price = '0';
            $taxCom = $data->ContractToTypeLoan->TypeLoanToCompany->Company_Id;
            $ComBranch = $data->ContractToTypeLoan->TypeLoanToCompany->Company_Branch;
            $tax_id = '|' . $taxCom;
            $contract = preg_replace("/[^a-z\d]/i", '', @$data->Contract_Con);
            if ($user_zone == '50' || ($user_zone == '30' && $data->CodeLoan_Con == '01')) { //  BarCode สุราษฎร์ ไม่มี ref2
                $Bar = $tax_id . sprintf("%02d", $ComBranch) . chr(13) . $contract . chr(13) . '' . chr(13) . $ref_price;
            } else {
                $Bar = $tax_id . sprintf("%02d", $ComBranch) . chr(13) . $contract . chr(13) . '006' . chr(13) . $ref_price;
            }


            $NamepathBr = 'Br_' . $user_zone . '_' . $contract;
            $Bc_JPGgenerator = new Picqer\Barcode\BarcodeGeneratorPNG();
            file_put_contents(public_path() . '/cache_barcode/' . $NamepathBr . '.png', $Bc_JPGgenerator->getBarcode($Bar, $Bc_JPGgenerator::TYPE_CODE_128));

            $NamepathQr = 'Qr_' . $user_zone . '_' . $contract;
            $BQ_generator = new Picqer\Barcode\BarcodeGeneratorPNG();
            file_put_contents(public_path() . '/cache_barcode/' . $NamepathQr . '.svg', QrCode::size(100)->generate($Bar));

            $path = public_path() . '/assets/images/payments/form.jpg';
            $path2 = public_path() . '/assets/images/payments/form2.jpg';


            $type = $request->type;
            // if($data->ContractToTypeLoan->TypeLoanToCompany->View_payment==NULL){
            $view = \View::make('frontend.content-report.PDF.reportPayments', compact('data', 'path', 'type', 'Bar', 'contract', 'NamepathBr', 'NamepathQr', 'taxCom'));
            // }else{
            //     $view = \View::make('view_Contracts.reportPaymentsNoform', compact('data', 'path','type', 'Bar', 'contract', 'NamepathBr', 'NamepathQr','taxCom'));
            // }
            $html = $view->render();

            // $view2 = \View::make('SCHEMA_Fn_KB.reportPaymentsback', compact('data', 'path','type', 'Bar', 'contract'));
            // $html2 = $view2->render();

            $pdf = new PDF();
            $pdf::SetTitle('ใบนำฝากชำระเงินค่าสินค้าหรือค่าบริการ');
            $pdf::AddPage("P", 'A4');
            // $pdf::SetMargins(5, 1, 1, 1);
            // $pdf::SetFont('thsarabun', '', 10, '', true);
            // $pdf::SetAutoPageBreak(TRUE, 10);
            // $pdf::WriteHTML($html, true, false, true, false, '');

            $pdf::SetMargins(0, 0, 0, 0);
            $pdf::SetFont('thsarabun', '', 16, '', true);
            $pdf::SetAutoPageBreak(TRUE, 10);
            if ($data->ContractToTypeLoan->TypeLoanToCompany->View_payment == NULL) {
                $pdf::Image($path, 0, 0, 215, 297, '', '', '', false, 300, '', false, false, 0);
            }
            $pdf::WriteHTML($html, true, false, true, false, '');

            // $pdf::AddPage();

            // $pdf::SetMargins(1, 1, 1, 1);
            // $pdf::Image($path2, 0, 0, 215, 297, '', '', '', false, 600, '', false, false, 0);
            // $pdf::WriteHTML($html2, true, false, true, false, '');
            $pdf::Output('report.pdf');
        } elseif ($request->type == 3) {
            $Fdate = $request->Fdate;
            $Tdate = $request->Tdate;
            $Branch = $request->Branch_Con;
            $Status = $request->Status_Con;

            $Loans = explode("-", $request->TypeLoans);
            if ($request->TypeLoans != NULL) {
                $codeLoans = $Loans[0];
                $nameLoans = $Loans[1];
            } else {
                $codeLoans = NULL;
                $nameLoans = NULL;
            }

            $data = Pact_Contracts::where('UserZone', auth()->user()->zone)
                ->when(!empty($codeLoans), function ($q) use ($codeLoans) {
                    return $q->where('CodeLoan_Con', $codeLoans);
                })
                ->whereBetween('DateConfirmApp_Con', [$Fdate, $Tdate])
                ->when(!empty($Branch), function ($q) use ($Branch) {
                    return $q->where('BranchSent_Con', $Branch);
                })
                ->orderBy('BranchSent_Con')
                ->get();

            $view = \View::make('frontend.content-report.PDF.ReportDueDate', compact('data', 'Fdate', 'Tdate', 'codeLoans', 'nameLoans'));
            $html = $view->render();

            $pdf = new PDF();
            $pdf::SetTitle('รายงานขออนุมัติสินเชื่อ');
            $pdf::AddPage('L', 'A4');
            $pdf::SetY(2, true, true);
            $pdf::SetMargins(5, 5, 5, 0);
            $pdf::SetFont('freeserif', '', 8, '', true);
            $pdf::SetAutoPageBreak(TRUE, 18);
            $pdf::WriteHTML($html, true, false, true, false, '');
            $pdf::Output('ReportDueDate.pdf');
        } elseif ($request->type == 4) {
            return Excel::download(new DataExportContract, 'รายงานตามเลขที่สัญญา.xls');
        } elseif ($request->type == 5) {

            $u_zone = auth()->user()->zone;
            $Loans = explode("-", $request->TypeLoans);
            $codeLoans = @$Loans[0];
            $nameLoans = @$Loans[1];
            $Fdate = $request->Fdate;
            $Tdate = $request->Tdate;
            $Branch = $request->Branch_Con;
            $Status = $request->Status_Con;
            $flag = $request->flag;
            $Zone_Con = $request->Zone_Con;
            $data = Pact_Contracts::
                when($Zone_Con == "", function ($q) use ($u_zone) {
                    return $q->where('UserZone', $u_zone);
                })

                // ->when($flag==4, function ($q) {
                //     return $q->leftJoin('Data_StatusContract','Pact_Contracts.id','=','Data_StatusContract.PactCon_id');
                // })


                ->when(!empty($Fdate) && !empty($Tdate) && ($flag == 1 || $flag == 2 || $flag == 6 || $flag == 7 || $flag == 8), function ($q) use ($Fdate, $Tdate) {
                    //return $q->whereBetween('Date_monetary', [$Fdate, $Tdate])->whereNotNull('Approve_monetary');
                    return $q->whereBetween(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"), [$Fdate, $Tdate])->whereNotNull('Approve_monetary');
                })
                ->when(!empty($Fdate) && !empty($Tdate) && ($flag == 4), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('Date_con', [$Fdate, $Tdate]);
                })
                ->when(!empty($Branch), function ($q) use ($Branch) {
                    return $q->where('BranchSent_Con', $Branch);
                })
                ->when(!empty($codeLoans), function ($q) use ($codeLoans) {
                    return $q->where('CodeLoan_Con', $codeLoans);
                })

                //->orderBy('Date_monetary', 'ASC')
                ->get();

            if ($request->flag == 1 || $request->flag == 4) {

                return view('frontend.content-report.EXCEL.contractReport', compact('data'));
            } elseif ($request->flag == 2) {
                //return view('frontend.content-report.EXCEL.testExcel', compact('data')); 
                return view('frontend.content-report.EXCEL.MDTodayReport', compact('data'));
            } elseif ($request->flag == 3) {
                $status_cus = TB_StatusCustomers::generateQuery();
                $dataBranch = TB_Branchs::generateQuery();

                $n_branch = array();
                $c = 0;
                foreach ($dataBranch as $id_branch) {
                    $a_count = array();
                    $a_count[] = $id_branch->id;
                    $a_count[] = $id_branch->Name_Branch;
                    $a_count[] = $id_branch->NickName_Branch;
                    $a_count[] = $id_branch->Traget_Branch;
                    $n_branch[$c] = $a_count;
                    $c++;
                }

                return view('frontend.content-report.EXCEL.accTodayReport', compact('data', 'status_cus', 'n_branch', 'Fdate', 'Tdate'));

            } elseif ($request->flag == 5) {
                $data = Pact_Contracts::whereNotNull('Approve_monetary')
                    ->whereNotNull('Date_Checkers')
                    // ->when($flag==4, function ($q) {
                    //     return $q->leftJoin('Data_StatusContract','Pact_Contracts.id','=','Data_StatusContract.PactCon_id');
                    // })
                    ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween('Date_con', [$Fdate, $Tdate]);
                    })


                    ->where('UserZone', $u_zone)
                    ->orderBy('Contract_Con', 'ASC')
                    ->get();

                return view('frontend.content-report.EXCEL.CheckerReport', compact('data', 'Status'));
            } elseif ($request->flag == 6) {

                return view('frontend.content-report.EXCEL.AuditReport', compact('data', 'Status'));
            } elseif ($request->flag == 7) {

                return view('frontend.content-report.EXCEL.customerPAReport', compact('data', 'Status'));
            } elseif ($request->flag == 8) {
                return view('frontend.content-report.EXCEL.DataPrivotReport', compact('data', 'Status'));
            } elseif ($request->flag == 9) { //Report view Assets

                $Fdate = $request->Fdate;
                $Tdate = $request->Tdate;
                $user_zone = auth()->user()->zone;
                //return view('main_report.OS4KH', compact('type','TypeAssets','dataBranchs','FlagPage'));


                $data = Pact_Contracts::whereNotNull('Approve_monetary')
                    ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"), [$Fdate, $Tdate]);
                    })
                    ->where('UserZone', $user_zone)
                    ->whereNotIn('CodeLoan_Con', ['01', '05', '07'])
                    ->orderBy('Contract_Con', 'ASC')
                    ->get();
                $dataCusAll = array();

                $n = 1;
                foreach ($data as $key => $value) {
                    $arr = array();
                    $arr[] = '5';
                    $arr[] = 'กู้ยืมเงิน';
                    $arr[] = $value->ContractToCus->IDCard_cus;
                    $arr[] = $value->ContractToCus->Prefix . " " . $value->ContractToCus->Name_Cus;
                    $arr[] = $value->Contract_Con;
                    $cal = $value->ContractToDataCusTags->TagToCulculate;
                    $pa = 0;
                    if ($cal->Buy_PA == "Yes" && $cal->Includ_PA == "Yes") {
                        $pa = floatval($cal->Insurance_PA);
                    }
                    $total = floatval($cal->Cash_Car) + floatval($cal->Process_Car) + $pa;
                    $arr[] = $total;
                    $arr[] = $total / 2000;
                    $dataCusAll[$n] = $arr;
                    $gard = @$value->ContractToGuarantor;
                    if (count($gard) > 0) {
                        foreach ($gard as $key => $valueGr) {
                            $n++;
                            $arrGR = array();
                            $arrGR[] = '17';
                            $arrGR[] = 'ค้ำประกัน';
                            $arrGR[] = $valueGr->GuarantorToGuarantorCus->IDCard_cus;
                            $arrGR[] = $valueGr->GuarantorToGuarantorCus->Prefix . " " . $valueGr->GuarantorToGuarantorCus->Name_Cus;
                            $arrGR[] = $value->Contract_Con;

                            $arrGR[] = 0;
                            $arrGR[] = 10;
                            $dataCusAll[$n] = $arrGR;
                        }

                    }
                    $n++;
                }
                //dd( $dataCusAll[1][1]);
                $view = \View::make('frontend.content-report.PDF.OS4KH', compact('dataCusAll'));

                $html = $view->render();
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
                $pdf->setPaper('a4', 'landscape');
                return $pdf->stream();


            }
        } elseif ($request->type == 6) {
            // $SetSearchMoth = explode("-", $request->SearchMoth);
            // $setValue = date('Y')."-".$SetSearchMoth[0];
            // $setValueName = $SetSearchMoth[1];
            $Fdate = $request->Fdate;
            $Tdate = $request->Tdate;
            //FORMAT (cast(a.Date_monetary as date), 'yyyy-MM') = '".$setValue."'

            $data_isNull = DB::select("SELECT Case When (f.Name_TypePoss is NULL)  then 'ที่ดิน' else f.Name_TypePoss end as typePoss,
                SUM(Case When (a.UserZone = 10)  then 1 else 0 end) as PN ,
                SUM(Case When (a.UserZone = 20)  then 1 else 0 end) as HY ,
                SUM(Case When (a.UserZone = 30)  then 1 else 0 end) as NK ,
                SUM(Case When (a.UserZone = 40)  then 1 else 0 end) as KB ,
                SUM(Case When (a.UserZone = 50)  then 1 else 0 end) as SR ,
                count(a.UserZone) as Zoneall
                from
                Pact_Contracts a
                left join Pact_Indentures b on a.id = b.PactCon_id
                left join Pact_Operatedfees c on c.id = b.PactCon_id
                left join Data_Assets d on d.id = b.Asset_id
                left join Data_AssetsDetails e on d.id = e.DataAsset_Id
                left join TB_TypeAssetsPoss f on e.PossessionState_Code=f.Code_TypePoss
                where c.Broker_id is null and a.Approve_monetary is not null and FORMAT (cast(a.Date_monetary as date), 'yyyy-MM-dd') BETWEEN '" . $Fdate . "' AND '" . $Tdate . "' group by f.Name_TypePoss");

            $data_notNull = DB::select("SELECT Case When (f.Name_TypePoss is NULL)  then 'ที่ดิน' else f.Name_TypePoss end as typePoss,
                SUM(Case When (a.UserZone = 10)  then 1 else 0 end) as PN ,
                SUM(Case When (a.UserZone = 20)  then 1 else 0 end) as HY ,
                SUM(Case When (a.UserZone = 30)  then 1 else 0 end) as NK ,
                SUM(Case When (a.UserZone = 40)  then 1 else 0 end) as KB ,
                SUM(Case When (a.UserZone = 50)  then 1 else 0 end) as SR ,
                count(a.UserZone) as Zoneall
                from
                Pact_Contracts a
                left join Pact_Indentures b on a.id = b.PactCon_id
                left join Pact_Operatedfees c on c.id = b.PactCon_id
                left join Data_Assets d on d.id = b.Asset_id
                left join Data_AssetsDetails e on d.id = e.DataAsset_Id
                left join TB_TypeAssetsPoss f on e.PossessionState_Code=f.Code_TypePoss
                where c.Broker_id is not null and a.Approve_monetary is not null and FORMAT (cast(a.Date_monetary as date), 'yyyy-MM-dd') BETWEEN '" . $Fdate . "' AND '" . $Tdate . "' group by f.Name_TypePoss");

            $DataisNull = [];
            $DatanotNull = [];
            foreach ($data_isNull as $value) {
                $b = array();
                $b[] = $value->PN;
                $b[] = $value->HY;
                $b[] = $value->NK;
                $b[] = $value->KB;
                $b[] = $value->SR;
                $b[] = $value->Zoneall;
                $DataisNull[$value->typePoss] = $b;
            }

            foreach ($data_notNull as $value) {
                $b = array();
                $b[] = $value->PN;
                $b[] = $value->HY;
                $b[] = $value->NK;
                $b[] = $value->KB;
                $b[] = $value->SR;
                $b[] = $value->Zoneall;
                $DatanotNull[$value->typePoss] = $b;
            }

            $dataCont = DB::select("SELECT b.Loan_Com , 
                SUM(Case When (a.UserZone = 10)  then 1 else 0 end) as PN ,
                SUM(Case When (a.UserZone = 20)  then 1 else 0 end) as HY ,
                SUM(Case When (a.UserZone = 30)  then 1 else 0 end) as NK ,
                SUM(Case When (a.UserZone = 40)  then 1 else 0 end) as KB ,
                SUM(Case When (a.UserZone = 50)  then 1 else 0 end) as SR ,
                count(a.UserZone) as Zoneall
                from Pact_Contracts a
                left join TB_TypeLoans b on a.CodeLoan_Con = b.Loan_Code
                where a.Approve_monetary is not null and FORMAT (cast(a.Date_monetary as date), 'yyyy-MM-dd') BETWEEN '" . $Fdate . "' AND '" . $Tdate . "' group by b.Loan_Com");

            $dataPrice = [];
            for ($i = 10; $i < 60; $i = $i + 10) {

                $Price = DB::select("SELECT a.UserZone ,
                        SUM(Case When (e.Loan_Com = 1)  then (d.Cash_Car+d.Process_Car + (Case When d.Buy_PA='Yes' and d.Include_PA='Yes' then d.Insurance_PA else 0 end)) else 0 end) as loan ,
                        SUM(Case When (e.Loan_Com = 2)  then (d.Cash_Car+d.Process_Car  + (Case When d.Buy_PA='Yes' and d.Include_PA='Yes' then d.Insurance_PA else 0 end)) else 0 end) as leasing ,
                        SUM((d.Cash_Car+d.Process_Car) + (Case When d.Buy_PA='Yes' and d.Include_PA='Yes' then d.Insurance_PA else 0 end)) as total ,
                        SUM((d.Cash_Car+d.Process_Car) + (Case When d.Buy_PA='Yes' and d.Include_PA='Yes' then d.Insurance_PA else 0 end))/count(a.Contract_Con) as con,
                        count(a.Contract_Con) as count_con
                        from Pact_Contracts a
                        left join Pact_Operatedfees b on a.id = b.PactCon_id
                        left join Data_CusTags c on a.DataTag_id = c.id
                        left join Data_CusTagCalculates d on c.id = d.DataTag_id
                        left join TB_TypeLoans e on a.CodeLoan_Con = e.Loan_Code
                        where a.Approve_monetary is not null and  FORMAT (cast(a.Date_monetary as date), 'yyyy-MM-dd')  BETWEEN '" . $Fdate . "' AND '" . $Tdate . "' and a.UserZone = '" . $i . "' group by a.UserZone order by a.UserZone");

                $b = array();
                $b[] = @$Price[0]->leasing;
                $b[] = @$Price[0]->loan;
                $b[] = @$Price[0]->total;
                $b[] = @$Price[0]->con;
                $b[] = @$Price[0]->count_con;

                $dataPrice[$i] = $b;
            }
            $SumBroker = [];
            for ($i2 = 10; $i2 < 60; $i2 = $i2 + 10) {


                $dataBroker = DB::select("SELECT a.UserZone ,
                count(a.Contract_Con) as con,
                SUM(Case When (b.Broker_id is not null)  then 1 else 0 end) as broker_n ,
                SUM((d.Cash_Car+d.Process_Car)+ (Case When d.Buy_PA='Yes' and d.Include_PA='Yes' then d.Insurance_PA else 0 end)) as total ,
                SUM(Case When (b.Broker_id is not null)  then b.Commission_Broker_Prices else 0 end) as broker_price
                from Pact_Contracts a
                left join Pact_Operatedfees b on a.id = b.PactCon_id
                left join Data_CusTags c on a.DataTag_id = c.id
                left join Data_CusTagCalculates d on c.id = d.DataTag_id
                left join TB_TypeLoans e on a.CodeLoan_Con = e.Loan_Code
                where a.Approve_monetary is not null and FORMAT (cast(a.Date_monetary as date), 'yyyy-MM-dd') BETWEEN '" . $Fdate . "' AND '" . $Tdate . "' and a.UserZone = '" . $i2 . "'  group by a.UserZone order by a.UserZone");


                $b = array();
                $b[] = @$dataBroker[0]->con;
                $b[] = @$dataBroker[0]->broker_n;
                $b[] = @$dataBroker[0]->total;
                $b[] = @$dataBroker[0]->broker_price;
                if (intval(@$dataBroker[0]->con) > 0) {
                    $perNumBrok = floatval(floatval(@$dataBroker[0]->broker_n) / floatval(@$dataBroker[0]->con)) * 100;
                } else {
                    $perNumBrok = 0;
                }
                $b[] = $perNumBrok;
                if (intval(@$dataBroker[0]->total) > 0) {
                    $perSumBrok = floatval(floatval(@$dataBroker[0]->broker_price) / floatval(@$dataBroker[0]->total)) * 100;
                } else {
                    $perSumBrok = 0;
                }
                $b[] = $perSumBrok;
                $SumBroker[$i2] = $b;

            }

            $view = \View::make('frontend.content-report.PDF.reportAccordingTotal', compact('DataisNull', 'DatanotNull', 'dataCont', 'dataPrice', 'SumBroker', 'Fdate', 'Tdate'));
            $html = $view->render();

            $pdf = new PDF();
            $pdf::SetTitle('รายงานตามยอดจัดรวม');
            $pdf::AddPage('L', 'A4');
            $pdf::SetY(2, true, true);
            $pdf::SetMargins(5, 5, 5, 0);
            $pdf::SetFont('freeserif', '', 10, '', true);
            $pdf::SetAutoPageBreak(TRUE, 10);
            $pdf::WriteHTML($html, true, false, true, false, '');
            $pdf::Output('ReportAccordingTotal.pdf');
        } elseif ($request->type == 7) {
            // $Loans = explode("-", $request->TypeLoans);
            // $codeLoans = $Loans[0];
            // $nameLoans = $Loans[1];
            $Fdate = $request->Fdate;
            $Tdate = $request->Tdate;
            $Branch = $request->Branch_Con;
            $Status = $request->Status_Con;
            $flag = $request->flag;
            $type = $request->type;

            if ($request->flag == 1) {
                return Excel::download(new DataExportCus, 'รายงานลูกค้า.xls');
            } elseif ($request->flag == 2) {
                return Excel::download(new DataExportCusKPI, 'รายงานลูกค้ามุ่งหวัง.xls');
            } elseif ($request->flag == 4) {
                return Excel::download(new DataExportBroker, 'รายงานผู้แนะนำ.xls');
            } elseif ($request->flag == 5) {
                return view('frontend.content-report.EXCEL.monthCredoReport', compact('type', 'Tdate', 'Fdate', 'flag'));
            } elseif ($request->flag == 6) {
                $user_zone = auth()->user()->zone;
                $data = Data_Customer::where('UserZone', $user_zone)
                    ->WhereBetween('created_at', [$Fdate, $Tdate])
                    ->get();
                $view = \View::make('frontend.content-report.PDF.ReportPDF', compact('data', 'Fdate', 'Tdate'));
                $html = $view->render();
                $pdf = new PDF();
                $pdf::SetTitle('รายงานScoreCredo');
                $pdf::AddPage('P', 'A4');
                $pdf::SetMargins(5, 5, 5, 0);
                $pdf::SetFont('thsarabun', '', 14, '', true);
                $pdf::SetAutoPageBreak(TRUE, 20);
                $pdf::WriteHTML($html, true, false, true, false, '');
                $pdf::Output('ReportPayment.pdf');
            } elseif ($request->flag == 7) {
                return view('frontend.content-report.EXCEL.monthPaReport', compact('type', 'Tdate', 'Fdate', 'flag'));
            }

        } elseif ($request->type == 8) { // Asset List

            // $Loans = explode("-", $request->TypeLoans);
            // $codeLoans = $Loans[0];
            // $nameLoans = $Loans[1];
            $Fdate = $request->Fdate;
            $Tdate = $request->Tdate;
            $Branch = $request->Branch_Con;
            $Status = $request->Status_Con;

            //dd($request);

            if ($request->FlagPage == 1) {
                return Excel::download(new DataExportAsset, 'รายงานทรัพย์_' . date('Y-m-d') . '.xls');
            } elseif ($request->FlagPage == 4) {
                return Excel::download(new DataExportBroker, 'รายงานผู้แนะนำ.xls');
            } elseif ($request->FlagPage == 5) {
                return view('frontend.content-report.EXCEL.monthCredoReport', compact('type', 'Tdate', 'Fdate', 'FlagPage'));
            } elseif ($request->FlagPage == 6) {
                $user_zone = auth()->user()->zone;
                $data = Data_Customer::where('UserZone', $user_zone)
                    ->WhereBetween('created_at', [$Fdate, $Tdate])
                    ->get();
                $view = \View::make('frontend.content-report.PDF.ReportPDF', compact('data', 'Fdate', 'Tdate'));
                $html = $view->render();
                $pdf = new TCPDF();
                $pdf::SetTitle('รายงานScoreCredo');
                $pdf::AddPage('P', 'A4');
                $pdf::SetMargins(5, 5, 5, 0);
                $pdf::SetFont('thsarabun', '', 14, '', true);
                $pdf::SetAutoPageBreak(TRUE, 20);
                $pdf::WriteHTML($html, true, false, true, false, '');
                $pdf::Output('ReportPayment.pdf');
            }


        }
    }
}