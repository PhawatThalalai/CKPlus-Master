<?php

namespace App\Http\Controllers\frontend;


use App\Http\Controllers\Controller;
use App\Models\TB_Constants\TB_Frontend\TB_StatusAudits;
use App\Models\TB_Constants\TB_Frontend\TB_StatusTagParts;
use App\Models\TB_Logs\Data_CredoFragments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use iio\libmergepdf\Merger;
use Picqer;
use QrCode;
use DB;
use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Helper;
use App\Models\User;

use App\Models\TB_Packages\TB_Promotios;

use App\Models\TB_DataCus\Data_Customers;
use App\Models\TB_DataCus\Data_CusAddress;
use App\Models\TB_DataCus\Data_CusCareers;
use App\Models\TB_DataCus\Data_CusAssets;
use App\Models\TB_DataBroker\Data_Broker;
use App\Models\TB_DataBroker\Data_BrokerAddress;
use App\Models\TB_DataBroker\TB_TypeBroker;

use App\Models\TB_Assets\Data_Assets;

use App\Models\TB_Constants\TB_Frontend\TB_TypeLoanCom;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_Constants\TB_Frontend\TB_RelationsCus;
use App\Models\TB_Constants\TB_Frontend\TB_TypeSecurities;
use App\Models\TB_Constants\TB_Frontend\TB_TypeLoanRegulations;
use App\Models\TB_Constants\TB_Frontend\TB_TypePurposeCode;
use App\Models\TB_Constants\TB_Frontend\TB_TypeUnregulatedLoan;
use App\Models\TB_Constants\TB_Frontend\TB_StatusCustomers;
use App\Models\TB_Constants\TB_Frontend\TB_TypeLoan;

//ratecar
use App\Models\Data_Assessments\Data_rateType;
use App\Models\Data_Assessments\Data_ratecar;
use App\Models\Data_Assessments\Data_ratemoto;
use App\Models\Data_Assessments\data_ratecars_kb;
use App\Models\Data_Assessments\data_ratemotos_kb;
use App\Models\Data_Assessments\Data_rateInterest;
use App\Models\Data_Assessments\Data_rateInterest_P03;

use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\TB_PactContracts\Pact_ContractsGuarantor;
use App\Models\TB_PactContracts\Pact_Operatedfees;
use App\Models\TB_PactContracts\Pact_Indentures;
use App\Models\TB_Commission\Commission_Broker;

use App\Models\TB_DataCus\Data_CusTags;
use App\Models\TB_view\View_ReportConData;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->form == 'Contract' || $request->form == 'AccReport') {          //Report view Contracts
            $TypeLoan = TB_TypeLoanCom::generateQuery();
            $dataBranchs = TB_Branchs::generateQuery();
            $form = $request->form;
            $report = $request->report;
            return view('frontend.content-report.viewReport', compact('form', 'report', 'TypeLoan', 'dataBranchs'));
        } elseif ($request->form == 'Datacus' || $request->form == 'audit') {          //Report view Contracts
            $dataBranchs = TB_Branchs::generateQuery();
            $status_audit = TB_StatusAudits::getStatusAudit();
            $status_custag = TB_StatusTagParts::generateQuery();
            $form = $request->form;
            $report = $request->report;
            return view('frontend.content-report.viewReport', compact('form', 'report', 'dataBranchs', 'status_audit','status_custag'));
        } elseif ($request->form == 'commission') {
            $form = $request->form;
            $report = $request->report;
            return view('frontend.content-report.viewReport', compact('form', 'report'));
        }
    }


    public function create(Request $request)
    {
        $id = $request->id;
        if ($request->report == 'ContractForm') {            //Contract form PDF
            $user_zone = auth()->user()->zone;
            $PactCon_id = $request->PactCon_id;
            $data = Pact_Contracts::where('id', $id)->first();

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
        } elseif ($request->report == 'PaymentForm') {            //card payment PDF
            $user_zone = auth()->user()->zone;
            $PactCon_id = $request->PactCon_id;
            $data = Pact_Contracts::where('id', $id)->first();
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
            if ($data->ContractToTypeLoan->TypeLoanToCompany->View_payment == NULL) {
                $view = \View::make('frontend.content-report.PDF.reportPayments', compact('data', 'path', 'type', 'Bar', 'contract', 'NamepathBr', 'NamepathQr', 'taxCom'));
            } else {
                $view = \View::make('frontend.content-report.PDF.reportPaymentsNoform', compact('data', 'path', 'type', 'Bar', 'contract', 'NamepathBr', 'NamepathQr', 'taxCom'));
            }
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
        } elseif ($request->report == 'Approve') { //รายงานขออนุมัติสินเชื่อ PDF
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
                ->whereBetween(DB::raw('CONVERT(date, DateConfirmApp_Con)'), [$Fdate, $Tdate])
                // ->whereBetween('DateConfirmApp_Con', [$Fdate, $Tdate])
                ->when(!empty($Branch), function ($q) use ($Branch) {
                    return $q->where('BranchSent_Con', $Branch);
                })
                ->where('Status_Con', '<>', 'cancel')
                ->orderBy('BranchSent_Con')
                ->get();

            $view = \View::make('frontend.content-report.PDF.ReportApprove', compact('data', 'Fdate', 'Tdate', 'codeLoans', 'nameLoans'));
            $html = $view->render();

            $pdf = new PDF();
            $pdf::SetTitle('รายงานขออนุมัติสินเชื่อ');
            $pdf::AddPage('L', 'A4');
            $pdf::SetY(2, true, true);
            $pdf::SetMargins(5, 5, 5, 0);
            $pdf::SetFont('freeserif', '', 8, '', true);
            $pdf::SetAutoPageBreak(TRUE, 18);
            $pdf::WriteHTML($html, true, false, true, false, '');
            $pdf::Output('ReportApprove.pdf');
        } elseif ($request->form == 'Contract') { // รายงาน หน้าการเงิน excel
            $u_zone = auth()->user()->zone;
            $Loans = explode("-", $request->TypeLoans);
            $codeLoans = @$Loans[0];
            $nameLoans = @$Loans[1];
            $Fdate = $request->Fdate;
            $Tdate = $request->Tdate;
            $Branch = $request->Branch_Con;
            $Status = $request->Status_Con;
            $report = $request->report;
            $Zone_Con = $request->Zone_Con;
            $userZone = User::where('zone', $u_zone)->withTrashed()->pluck('name', 'id')->all();

            //$data = Pact_Contracts::
            if ($request->report == 'ReportCondate' || $request->report == 'contractSuccess' || $request->report == 'MDToday' || $request->report == 'AccCash' || $request->report == 'contractSuccess') {
                $data = DB::table('View_ReportConData')->where('Status_Con', '<>', 'cancel');
            } elseif ($request->report == 'PAReport') {
                $data = DB::table('View_ReportPAData')->where('Status_Con', '<>', 'cancel');
            } elseif ($request->report == 'DataPrivot') {
                $data = DB::table('View_ReportAnalyze')->where('Status_Con', '<>', 'cancel');
            } else {
                $data = Pact_Contracts::where('Status_Con', '<>', 'cancel');
            }
            $data->when($Zone_Con == "", function ($q) use ($u_zone) {
                return $q->where('UserZone', $u_zone);
            })

                // ->when($flag==4, function ($q) {
                //     return $q->leftJoin('Data_StatusContract','Pact_Contracts.id','=','Data_StatusContract.PactCon_id');
                // })


                ->when(!empty($Fdate) && !empty($Tdate) && ($report == 'contractSuccess' || $report == 'MDToday' || $report == 6 || $report == 'PAReport' || $report == 'DataPrivot' || $report == 10 || $report == 11), function ($q) use ($Fdate, $Tdate) {
                    //return $q->whereBetween('Date_monetary', [$Fdate, $Tdate])->whereNotNull('Approve_monetary');
                    return $q->whereBetween(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"), [$Fdate, $Tdate])->whereNotNull('Date_monetary');
                })
                ->when(!empty($Fdate) && !empty($Tdate) && ($report == 'ReportCondate'), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween(DB::raw(" FORMAT (cast(Date_con as date), 'yyyy-MM-dd')"), [$Fdate, $Tdate]);
                })
                ->when(!empty($Branch), function ($q) use ($Branch) {
                    return $q->where('BranchSent_Con', $Branch);
                })
                ->when(!empty($codeLoans), function ($q) use ($codeLoans) {
                    return $q->where('CodeLoan_Con', $codeLoans);
                });
            //->orderBy('Date_monetary', 'ASC')
            $data = $data->get();

            if ($request->report == 'contractSuccess' || $request->report == 'ReportCondate') {

                return view('frontend.content-report.EXCEL.contractReport', compact('data', 'userZone'));
            } elseif ($request->report == 'MDToday') {
                //return view('frontend.content-report.EXCEL.testExcel', compact('data'));
                return view('frontend.content-report.EXCEL.MDTodayReport', compact('data'));
            } elseif ($request->report == 'AccCash') {
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

            } elseif ($request->report == 'AuditReport') {

                return view('frontend.content-report.EXCEL.AuditReport', compact('data', 'Status'));
            } elseif ($request->report == 'PAReport') {

                return view('frontend.content-report.EXCEL.customerPAReport', compact('data', 'Status'));
            } elseif ($request->report == 'DataPrivot') {
                return view('frontend.content-report.EXCEL.DataPrivotReport', compact('data', 'Status'));
            } elseif ($request->report == 'OS4KH') { //Report OS4KH

                $Fdate = $request->Fdate;
                $Tdate = $request->Tdate;
                $nameForm = $request->nameForm;
                $Position = $request->Position;
                $dateSend = $request->dateSend;




                $user_zone = auth()->user()->zone;
                //return view('main_report.OS4KH', compact('type','TypeAssets','dataBranchs','FlagPage'));


                $data = Pact_Contracts::whereNotNull('Approve_monetary')
                    ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"), [$Fdate, $Tdate]);
                    })
                    ->where('UserZone', $user_zone)
                    ->where('Status_Con', '<>', 'cancel')
                    ->whereNotIn('CodeLoan_Con', ['01', '05', '07', '15', '16', '18'])
                    ->orderBy('Contract_Con', 'ASC')
                    ->get();
                $dataCusAll = array();

                $totalLoan = 0;
                $totalAK = 0;
                $totalGuar= 0;
                $totalCon= 0;
                $n = 1;
                foreach ($data as $key => $value) {
                    $totalCon++;
                    $arr = array();
                    $arr[] = '5';
                    $arr[] = 'กู้ยืมเงิน';
                    $arr[] = $value->ContractToCus->IDCard_cus;
                    $arr[] = $value->ContractToCus->Prefix . " " . $value->ContractToCus->Firstname_Cus . " " . $value->ContractToCus->Surname_Cus;
                    $arr[] = $value->Contract_Con;
                    $cal = $value->ContractToDataCusTags->TagToCulculate;
                    $pa = 0;
                    if (strtoupper($cal->Buy_PA) == "YES" && strtoupper($cal->Include_PA) == "YES") {
                        $pa = floatval($cal->Insurance_PA);
                    }

                    $_valProcess_Car = 0;
                    if(strtoupper(@$cal->StatusProcess_Car) == 'YES'){
                      $_valProcess_Car = @$cal->Process_Car;
                    }
                    $total = floatval($cal->Cash_Car) + floatval($_valProcess_Car) + $pa;
                    $totalLoan = $totalLoan+$total;
                    $totalAK = $totalAK + ceil($total / 2000);
                    $arr[] = $total;
                    $arr[] = $total / 2000;
                    $dataCusAll[$n] = $arr;
                    $gard = @$value->ContractToGuarantor;
                    if (count($gard) > 0) {
                        foreach ($gard as $key => $valueGr) {
                            $totalGuar++;
                            $n++;
                            $arrGR = array();
                            $arrGR[] = '17';
                            $arrGR[] = 'ค้ำประกัน';
                            $arrGR[] = $valueGr->GuarantorToGuarantorCus->IDCard_cus;
                            $arrGR[] = $valueGr->GuarantorToGuarantorCus->Prefix . " " . $valueGr->GuarantorToGuarantorCus->Firstname_Cus . " " . $valueGr->GuarantorToGuarantorCus->Surname_Cus;
                            $arrGR[] = $value->Contract_Con;

                            $arrGR[] = 0;
                            $arrGR[] = 10;
                            $dataCusAll[$n] = $arrGR;
                        }

                    }
                    $n++;
                }
                //dd( $dataCusAll[1][1]);
                // $view = \View::make('frontend.content-report.PDF.OS4KH', compact('dataCusAll'));
                // $html = $view->render();
                // $pdf = \Barryvdh\DomPDF\Facade\PDF::loadHTML($html);
                // $pdf->setPaper('a4', 'landscape');
                // $pdf->render();
                // $view = \View::make('frontend.content-report.PDF.F-OS4KH', compact('totalLoan','totalCon','totalGuar','totalAK','dataCusAll'));
                // $html = $view->render();
                // $pdf2 = \Barryvdh\DomPDF\Facade\PDF::loadHTML($html);
                // $pdf2->setPaper('a4', 'portrait');

               //return $pdf->stream();

                $options = new Options();
                $options->set('isHtml5ParserEnabled', true);
                $options->set('isPhpEnabled', true);
                $options->set('isRemoteEnabled', true);
                $options->set('defaultFont',  asset('fonts/TF Pimpakarn.ttf') );

                $m = new Merger();
                 $view = \View::make('frontend.content-report.PDF.OS4KH', compact('dataCusAll','nameForm','Position','dateSend'));
                $html = $view->render();
                $dompdf = new  Dompdf($options);
                $dompdf->set_paper('a4', 'landscape');
                $dompdf->load_html( $html);
               $dompdf->render();

                $m->addRaw($dompdf->output());
                unset($dompdf);

               $dompdf =  new  Dompdf($options);
                  $view = \View::make('frontend.content-report.PDF.F-OS4KH', compact('totalLoan','totalCon','totalGuar','totalAK','dataCusAll','Fdate', 'Tdate','nameForm','Position','dateSend'));
                $html = $view->render();
                $dompdf->set_paper('A4', 'portrait');
                $dompdf->loadHTML( $html);
                $dompdf->render();
                $m->addRaw($dompdf->output());


                // $dompdf->stream('combined.pdf',array('Attachment'=>0,$m->merge()));
                $pathFile = 'OS4KH/OS4KH'.$user_zone.'.pdf';
               file_put_contents(storage_path($pathFile), $m->merge());

               $handle = fopen(storage_path($pathFile), 'rb');

                // Check if the file was opened successfully
                if ($handle === false) {
                    die('Failed to open the PDF file.');
                }

                // Set the appropriate headers for PDF output
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename="file.pdf"');

                // Output the PDF file content
                while (!feof($handle)) {
                    echo fread($handle, 8192); // Output in chunks
                }

                // Close the file handle
                fclose($handle);


            } elseif ($request->report == 'ReportExecutive') { // รายงานตามยอดจัดรวม ALL ZONE
                // $SetSearchMoth = explode("-", $request->SearchMoth);
                // $setValue = date('Y')."-".$SetSearchMoth[0];
                // $setValueName = $SetSearchMoth[1];
                $Fdate = $request->Fdate;
                $Tdate = $request->Tdate;
                //FORMAT (cast(a.Date_monetary as date), 'yyyy-MM') = '".$setValue."'

                $data_isNull = DB::select("SELECT Case When (f.Name_TypePoss is NULL)  then 'ที่ดิน' else f.Name_TypePoss end as typePoss,
                SUM(Case When (a.UserZone = 10 and a.CodeLoan_Con = '01')   then 1 else 0 end) as PN ,
				SUM(Case When (a.UserZone = 10 and a.CodeLoan_Con <> '01')  then 1 else 0 end) as PN2 ,
                SUM(Case When (a.UserZone = 20 and a.CodeLoan_Con = '01')  then 1 else 0 end) as HY ,
				SUM(Case When (a.UserZone = 20 and a.CodeLoan_Con <> '01')  then 1 else 0 end) as HY2 ,
                SUM(Case When (a.UserZone = 30 and a.CodeLoan_Con = '01')  then 1 else 0 end) as NK ,
				SUM(Case When (a.UserZone = 30 and a.CodeLoan_Con <> '01')  then 1 else 0 end) as NK2 ,
                SUM(Case When (a.UserZone = 40 and a.CodeLoan_Con = '01')  then 1 else 0 end) as KB ,
				SUM(Case When (a.UserZone = 40 and a.CodeLoan_Con <> '01')  then 1 else 0 end) as KB2 ,
                SUM(Case When (a.UserZone = 50 and a.CodeLoan_Con = '01')  then 1 else 0 end) as SR ,
				SUM(Case When (a.UserZone = 50 and a.CodeLoan_Con <> '01')  then 1 else 0 end) as SR2 ,
                SUM(Case When (a.CodeLoan_Con = '01')  then 1 else 0 end) as Zoneall,
                SUM(Case When (a.CodeLoan_Con <> '01')  then 1 else 0 end) as Zoneall2
                from
                Pact_Contracts a
                -- left join Pact_Indentures b on a.id = b.PactCon_id
                left join Pact_Operatedfees c on a.id = c.PactCon_id
                left join Pact_Indentures_Assets h on h.id = (SELECT TOP (1) id
                    FROM      dbo.Pact_Indentures_Assets
                    WHERE   (PactCon_id = a.id) and deleted_at is null order by id asc)
                left join Data_AssetsOwnerships i on i.id = h.Asset_id
                left join Data_Assets d on d.id = i.DataAsset_Id
                left join Data_AssetsDetails e on i.id = e.DataAssetOwn_Id
                left join TB_TypeAssetsPoss f on e.PossessionState_Code=f.Code_TypePoss
                left join Pact_ContractBrokers g on g.PactCon_id = a.id and g.deleted_at is null
                left join Data_CusTags j on j.id = a.DataTag_id
                where j.Type_Customer <> 'CUS-0012' and g.Broker_id is null and a.Approve_monetary is not null and FORMAT (cast(a.Date_monetary as date), 'yyyy-MM-dd') BETWEEN '" . $Fdate . "' AND '" . $Tdate . "' and Status_Con <> 'cancel'
                group by f.Name_TypePoss");

                $data_notNull = DB::select("SELECT Case When (f.Name_TypePoss is NULL)  then 'ที่ดิน' else f.Name_TypePoss end as typePoss,
                SUM(Case When (a.UserZone = 10 and a.CodeLoan_Con = '01')   then 1 else 0 end) as PN ,
				SUM(Case When (a.UserZone = 10 and a.CodeLoan_Con <> '01')  then 1 else 0 end) as PN2 ,
                SUM(Case When (a.UserZone = 20 and a.CodeLoan_Con = '01')  then 1 else 0 end) as HY ,
				SUM(Case When (a.UserZone = 20 and a.CodeLoan_Con <> '01')  then 1 else 0 end) as HY2 ,
                SUM(Case When (a.UserZone = 30 and a.CodeLoan_Con = '01')  then 1 else 0 end) as NK ,
				SUM(Case When (a.UserZone = 30 and a.CodeLoan_Con <> '01')  then 1 else 0 end) as NK2 ,
                SUM(Case When (a.UserZone = 40 and a.CodeLoan_Con = '01')  then 1 else 0 end) as KB ,
				SUM(Case When (a.UserZone = 40 and a.CodeLoan_Con <> '01')  then 1 else 0 end) as KB2 ,
                SUM(Case When (a.UserZone = 50 and a.CodeLoan_Con = '01')  then 1 else 0 end) as SR ,
				SUM(Case When (a.UserZone = 50 and a.CodeLoan_Con <> '01')  then 1 else 0 end) as SR2 ,
                SUM(Case When (a.CodeLoan_Con = '01')  then 1 else 0 end) as Zoneall,
				SUM(Case When (a.CodeLoan_Con <> '01')  then 1 else 0 end) as Zoneall2
                from
                Pact_Contracts a
                left join Pact_Operatedfees c on a.id = c.PactCon_id
                left join Pact_Indentures_Assets h on h.id = (SELECT TOP (1) id
                    FROM      dbo.Pact_Indentures_Assets
                    WHERE   (PactCon_id = a.id) and deleted_at is null order by id asc)
                left join Data_AssetsOwnerships i on i.id = h.Asset_id
                left join Data_Assets d on d.id = i.DataAsset_Id
                left join Data_AssetsDetails e on i.id = e.DataAssetOwn_Id
                left join TB_TypeAssetsPoss f on e.PossessionState_Code=f.Code_TypePoss
                left join Pact_ContractBrokers g on g.PactCon_id = a.id and g.deleted_at is null
                left join Data_CusTags j on j.id = a.DataTag_id
                where j.Type_Customer <> 'CUS-0012' and  g.Broker_id is not null and a.Approve_monetary is not null and FORMAT (cast(a.Date_monetary as date), 'yyyy-MM-dd') BETWEEN '" . $Fdate . "' AND '" . $Tdate . "' and Status_Con <> 'cancel'   group by f.Name_TypePoss");

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
                    $b[] = $value->PN2;
                    $b[] = $value->HY2;
                    $b[] = $value->NK2;
                    $b[] = $value->KB2;
                    $b[] = $value->SR2;
                    $b[] = $value->Zoneall2;
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
                    $b[] = $value->PN2;
                    $b[] = $value->HY2;
                    $b[] = $value->NK2;
                    $b[] = $value->KB2;
                    $b[] = $value->SR2;
                    $b[] = $value->Zoneall2;
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
                left join Data_CusTags h on h.id = a.DataTag_id
                where h.Type_Customer <> 'CUS-0012' and  a.Approve_monetary is not null and FORMAT (cast(a.Date_monetary as date), 'yyyy-MM-dd') BETWEEN '" . $Fdate . "' AND '" . $Tdate . "' and Status_Con <> 'cancel' group by b.Loan_Com");

                $dataCont2 = DB::select("SELECT b.Loan_Name ,
            SUM(Case When (a.UserZone = 10)  then 1 else 0 end) as PN ,
            SUM(Case When (a.UserZone = 10)  then (c.Cash_Car+ (Case When c.StatusProcess_Car='yes' then c.Process_Car else 0 end) + (Case When c.Buy_PA='yes' and c.Include_PA='yes' then c.Insurance_PA else 0 end)) else 0 end) as PN2 ,
            SUM(Case When (a.UserZone = 20)  then 1 else 0 end) as HY ,
            SUM(Case When (a.UserZone = 20)  then (c.Cash_Car+(Case When c.StatusProcess_Car='yes' then c.Process_Car else 0 end)  + (Case When c.Buy_PA='yes' and c.Include_PA='yes' then c.Insurance_PA else 0 end)) else 0 end) as HY2 ,
            SUM(Case When (a.UserZone = 30)  then 1 else 0 end) as NK ,
            SUM(Case When (a.UserZone = 30)  then (c.Cash_Car+(Case When c.StatusProcess_Car='yes' then c.Process_Car else 0 end)  + (Case When c.Buy_PA='yes' and c.Include_PA='yes' then c.Insurance_PA else 0 end)) else 0 end) as NK2 ,
            SUM(Case When (a.UserZone = 40)  then 1 else 0 end) as KB ,
            SUM(Case When (a.UserZone = 40)  then (c.Cash_Car+(Case When c.StatusProcess_Car='yes' then c.Process_Car else 0 end)  + (Case When c.Buy_PA='yes' and c.Include_PA='yes' then c.Insurance_PA else 0 end)) else 0 end) as KB2 ,
            SUM(Case When (a.UserZone = 50)  then 1 else 0 end) as SR ,
            SUM(Case When (a.UserZone = 50)  then (c.Cash_Car+(Case When c.StatusProcess_Car='yes' then c.Process_Car else 0 end)  + (Case When c.Buy_PA='yes' and c.Include_PA='yes' then c.Insurance_PA else 0 end)) else 0 end) as SR2 ,
            count(a.UserZone) as Zoneall,
            SUM(c.Cash_Car+(Case When c.StatusProcess_Car='yes' then c.Process_Car else 0 end) + (Case When c.Buy_PA='yes' and c.Include_PA='yes' then c.Insurance_PA else 0 end)) as SumAll
            from Pact_Contracts a
            left join TB_TypeLoans b on a.CodeLoan_Con = b.Loan_Code
            left join Data_CusTagCalculates c on a.DataTag_id = c.DataTag_id
            left join Data_CusTags h on h.id = a.DataTag_id
            where h.Type_Customer <> 'CUS-0012' and  a.Approve_monetary is not null and FORMAT (cast(a.Date_monetary as date), 'yyyy-MM-dd')  BETWEEN '" . $Fdate . "' AND '" . $Tdate . "' and Status_Con <> 'cancel' group by b.Loan_Name");

                $dataLoan = [];
                $c_loan = 0;
                foreach ($dataCont2 as $key => $value) {
                    $dataArray = [];
                    $dataArray[] = $value->Loan_Name;
                    $dataArray[] = $value->PN;
                    $dataArray[] = $value->PN2;
                    $dataArray[] = $value->HY;
                    $dataArray[] = $value->HY2;
                    $dataArray[] = $value->NK;
                    $dataArray[] = $value->NK2;
                    $dataArray[] = $value->KB;
                    $dataArray[] = $value->KB2;
                    $dataArray[] = $value->SR;
                    $dataArray[] = $value->SR2;
                    $dataArray[] = $value->Zoneall;
                    $dataArray[] = $value->SumAll;

                    $dataLoan[$c_loan] = $dataArray;
                    $c_loan++;
                }

                $dataPrice = [];
                for ($i = 10; $i < 60; $i = $i + 10) {

                    $Price = DB::select("SELECT a.UserZone ,
                SUM(Case When (e.Loan_Com = 1)  then (d.Cash_Car+ (Case When d.StatusProcess_Car='yes' then d.Process_Car else 0 end)+ (Case When d.Buy_PA='yes' and d.Include_PA='yes' then d.Insurance_PA else 0 end)) else 0 end) as loan ,
                SUM(Case When (e.Loan_Com = 2)  then (d.Cash_Car+(Case When d.StatusProcess_Car='yes' then d.Process_Car else 0 end)  + (Case When d.Buy_PA='yes' and d.Include_PA='yes' then d.Insurance_PA else 0 end)) else 0 end) as leasing ,
                SUM((d.Cash_Car+(Case When d.StatusProcess_Car='yes' then d.Process_Car else 0 end)) + (Case When d.Buy_PA='yes' and d.Include_PA='yes' then d.Insurance_PA else 0 end)) as total ,
                SUM((d.Cash_Car+(Case When d.StatusProcess_Car='yes' then d.Process_Car else 0 end)) + (Case When d.Buy_PA='yes' and d.Include_PA='yes' then d.Insurance_PA else 0 end))/count(a.Contract_Con) as con,
                count(a.Contract_Con) as count_con
                from Pact_Contracts a
                left join Pact_Operatedfees b on a.id = b.PactCon_id
                left join Data_CusTags c on a.DataTag_id = c.id
                left join Data_CusTagCalculates d on c.id = d.DataTag_id
                left join TB_TypeLoans e on a.CodeLoan_Con = e.Loan_Code
                where c.Type_Customer <> 'CUS-0012' and a.Approve_monetary is not null and  FORMAT (cast(a.Date_monetary as date), 'yyyy-MM-dd')  BETWEEN '" . $Fdate . "' AND '" . $Tdate . "' and a.UserZone = '" . $i . "' and Status_Con <> 'cancel' group by a.UserZone order by a.UserZone");

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
                SUM(Case When (f.Broker_id is not null and f.deleted_at is null)  then 1 else 0 end) as broker_n ,
                SUM((d.Cash_Car+(Case When d.StatusProcess_Car='yes' then d.Process_Car else 0 end))+ (Case When d.Buy_PA='yes' and d.Include_PA='yes' then d.Insurance_PA else 0 end)) as total ,
                SUM(Case When (f.Broker_id is not null and f.deleted_at is null)  then f.Commission_Broker else 0 end) as broker_price
                from Pact_Contracts a
                left join Pact_Operatedfees b on a.id = b.PactCon_id
                left join Data_CusTags c on a.DataTag_id = c.id
                left join Data_CusTagCalculates d on c.id = d.DataTag_id
                left join TB_TypeLoans e on a.CodeLoan_Con = e.Loan_Code
                left join Pact_ContractBrokers f on f.PactCon_id = a.id
                where c.Type_Customer <> 'CUS-0012' and  a.Approve_monetary is not null and FORMAT (cast(a.Date_monetary as date), 'yyyy-MM-dd') BETWEEN '" . $Fdate . "' AND '" . $Tdate . "' and a.UserZone = '" . $i2 . "' and Status_Con <> 'cancel' group by a.UserZone order by a.UserZone");


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

                $zoneName = array('10' => 'ปัตตานี', '20' => 'หาดใหญ่', '30' => 'นครศรี', '40' => 'กระบี่', '50' => 'สุราษฏร์');
                $avgProduct = DB::select("SELECT UserZone,Loan_Name,count(Contract_Con) as Contno ,
                cast (avg(case when Buy_PA='yes' and Include_PA = 'yes' then  Cash_Car + (Case When StatusProcess_Car='yes' then Process_Car else 0 end) + CalPA
                    when Buy_PA='yes' and Include_PA = 'no' then  Cash_Car + (Case When StatusProcess_Car='yes' then Process_Car else 0 end)  else Cash_Car+ (Case When StatusProcess_Car='yes' then Process_Car else 0 end)   end
                / case when RatePrices<>0 then RatePrices else Price_Asset end) as decimal(12,2)) as LTV ,
                sum(case when RatePrices<>0 then RatePrices else Price_Asset end) as RateCar,
                cast (avg(case when Buy_PA='yes' and Include_PA = 'yes' then  Cash_Car + (Case When StatusProcess_Car='yes' then Process_Car else 0 end)  + CalPA
                    when Buy_PA='yes' and Include_PA = 'no' then  Cash_Car + (Case When StatusProcess_Car='yes' then Process_Car else 0 end)  else Cash_Car+ (Case When StatusProcess_Car='yes' then Process_Car else 0 end)   end) as decimal(12,2)) as Avgcash,
                cast (sum(case when Buy_PA='yes' and Include_PA = 'yes' then  Cash_Car + (Case When StatusProcess_Car='yes' then Process_Car else 0 end)  + CalPA
                    when Buy_PA='yes' and Include_PA = 'no' then  Cash_Car + (Case When StatusProcess_Car='yes' then Process_Car else 0 end)  else Cash_Car+ (Case When StatusProcess_Car='yes' then Process_Car else 0 end)   end) as decimal(12,2)) as Allcash,
                cast (sum(case when  DATEDIFF(day, OccupiedDT,Date_con  )  < 30 then 1 else 0 end) as decimal(12,2)) as ConMin30,
                cast (cast (sum(case when  DATEDIFF(day, OccupiedDT,Date_con  )  < 30 then 1 else 0 end) as decimal(12,2))/count(Contract_Con) as decimal(12,2)) as MIN30,
                cast (sum(case when  DATEDIFF(day, OccupiedDT,Date_con  )  >= 30 and DATEDIFF(day, OccupiedDT,Date_con  )<60 then 1 else 0 end) as decimal(12,2)) as ConMax30,
                cast (cast (sum(case when DATEDIFF(day, OccupiedDT,Date_con ) >= 30  and DATEDIFF(day, OccupiedDT,Date_con )  <60 then 1 else 0 end) as decimal(12,2))/count(Contract_Con) as decimal(12,2)) as MAX30,
                cast (sum(case when  DATEDIFF(day, OccupiedDT,Date_con  )  >= 60 then 1 else 0 end) as decimal(12,2)) as ConMax60,
                cast (cast (sum(case when DATEDIFF(day, OccupiedDT,Date_con  )  >= 60 then 1 else 0 end) as decimal(12,2))/count(Contract_Con) as decimal(12,2)) as MAX60
                FROM [dbo].[View_ReportConData]
                WHERE Approve_monetary is not null and FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd') BETWEEN '" . $Fdate . "' AND '" . $Tdate . "'  and Status_Con <> 'cancel'  group by UserZone ,Loan_Name order by Loan_Name");




                $view = \View::make('frontend.content-report.PDF.reportAccordingTotal', compact('DataisNull', 'DatanotNull', 'dataLoan', 'zoneName', 'dataCont', 'dataPrice', 'SumBroker', 'Fdate', 'Tdate', 'avgProduct'));
                $html = $view->render();

                // $pdf = new PDF();
                // $pdf::SetTitle('รายงานตามยอดจัดรวม');
                // $pdf::AddPage('L', 'A4');
                // $pdf::SetY(2, true, true);
                // $pdf::SetMargins(5, 5, 5, 0);
                // $pdf::SetFont('freeserif', '', 10, '', true);
                // $pdf::SetAutoPageBreak(TRUE, 10);
                // $pdf::WriteHTML($html,true,false,true,false,'');
                // $pdf::Output('ReportAccordingTotal.pdf');
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
                $pdf->setPaper('a4', 'landscape');
                return $pdf->stream();
            } elseif ($request->report == 'CheckerReport') {
                $Fdate = $request->Fdate;
                $Tdate = $request->Tdate;
                $user_zone = auth()->user()->zone;
                $data = Pact_Contracts::whereNotNull('Approve_monetary')
                    ->whereNotNull('Date_Checkers')
                    // ->when($flag==4, function ($q) {
                    //     return $q->leftJoin('Data_StatusContract','Pact_Contracts.id','=','Data_StatusContract.PactCon_id');
                    // })
                    ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween(DB::raw('CONVERT(date, Date_con)'), [$Fdate, $Tdate]);
                    })


                    ->where('UserZone', $user_zone)
                    ->orderBy('Contract_Con', 'ASC')
                    ->get();

                return view('frontend.content-report.EXCEL.CheckerReport', compact('data', 'Status'));
            } elseif ($request->report == 'extendLand') {
                $Fdate = $request->Fdate;
                $Tdate = $request->Tdate;
                $user_zone = auth()->user()->zone;
                $data = Pact_Contracts::
                    whereHas('ContractToDataCusTags', function ($query) {
                        $query->where('Type_Customer', '=', 'CUS-0012');
                    })
                    ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween(DB::raw(" FORMAT (cast(Date_con as date), 'yyyy-MM-dd')"), [$Fdate, $Tdate]);
                    })
                    ->where('Status_Con', '<>', 'cancel')->where('UserZone', $user_zone)->get();

                return view('frontend.content-report.EXCEL.extenLandReport', compact('data'));
            }
        } elseif ($request->form == 'Datacus') { // PP
            // $Loans = explode("-", $request->TypeLoans);
            // $codeLoans = $Loans[0];
            // $nameLoans = $Loans[1];
            $Fdate = $request->Fdate;
            $Tdate = $request->Tdate;
            $Branch = $request->Branch_Con;
            $Status = $request->Status_Con;
            $flag = $request->Credo;
            $type = $request->form;
            $statusTxt = $request->statusTxt;

            if ($request->report == 'tracking-cus') {
                $user_zone = auth()->user()->zone;
                // $dataCus = DB::table('View_CusPP')->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                //             return $q->whereBetween('date_Tag', [$Fdate, $Tdate]);
                //         })
                //         ->where('UserZone', $user_zone)
                //        // ->where('Data_Customers.Status_Cus', '!=', 'cancel')
                //        ->when(!empty($Branch), function ($q) use ($Branch) {
                //             return $q->where('UserBranch', $Branch);
                //         })
                //         ->orderBY('date_Tag', 'DESC')
                //         ->get();

                $dataCus = Data_CusTags::leftJoin('Data_Customers', function ($join) {
                    $join->on('Data_CusTags.DataCus_id', '=', 'Data_Customers.id');
                })
                    ->leftJoin('Data_CusTagCalculates', function ($join) {
                        $join->on('Data_CusTags.id', '=', 'Data_CusTagCalculates.DataTag_id');
                    })
                    ->leftJoin('TB_TypeLoans', function ($join) {
                        $join->on('TB_TypeLoans.Loan_Code', '=', 'Data_CusTagCalculates.CodeLoans');
                    })
                    ->leftJoin('TB_Branchs', function ($join) {
                        $join->on('TB_Branchs.id', '=', 'Data_CusTags.BranchCont');
                    })
                    ->leftJoin('TB_TypeCusResources', function ($join) {
                        $join->on('TB_TypeCusResources.Code_CusResource', '=', 'Data_CusTags.Resource_Customer');
                    })
                    ->selectRaw("Data_CusTags.id,Data_Customers.Prefix,Data_Customers.PrefixOther,
                        Data_Customers.Name_Cus,Data_Customers.date_Cus,
                        Data_Customers.Phone_cus,Data_Customers.image_cus,
                        Data_Customers.Status_Cus,Data_CusTags.date_Tag,Data_CusTags.date_Tag,Data_CusTags.Credo_Score,
                        Data_CusTags.Status_Tag,Data_CusTags.Code_Tag,TB_TypeLoans.Loan_Name,Data_CusTagCalculates.Cash_Car,
                        TB_Branchs.Name_Branch,Data_CusTags.UserZone,TB_TypeCusResources.Name_CusResource")


                    ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween('Data_CusTags.date_Tag', [$Fdate, $Tdate]);
                    })
                    ->when(!empty($Branch), function ($q) use ($Branch) {
                                    return $q->where('Data_CusTags.BranchCont', $Branch);
                                })
                    ->when($statusTxt != 'all', function ($q) use ($statusTxt) {
                        return $q->where('Data_CusTags.Status_Tag', $statusTxt != '' ? $statusTxt : NULL);
                    })
                    ->where('Data_CusTags.UserZone', $user_zone)
                    ->where('Data_Customers.Status_Cus', '!=', 'cancel')

                    ->orderBY('Data_CusTags.date_Tag', 'DESC')
                    ->get();
                    $arrRole = ['administrator', 'superadmin', 'manager'];
                    $Position = auth()->user()->getRoleNames();
                    $Approve = $Position->filter(function ($item) use ($arrRole) {
                        return in_array($item, $arrRole);
                    });
                    $Approve = count($Approve);
                return view('frontend.content-report.EXCEL.PPReport', compact('dataCus','Approve'));
            } elseif ($request->report == 2) {
                return Excel::download(new DataExportCusKPI, 'รายงานลูกค้ามุ่งหวัง.xls');
            } elseif ($request->report == 4) {
                return Excel::download(new DataExportBroker, 'รายงานผู้แนะนำ.xls');
            } elseif ($request->report == 'monthlyCredo') {
                return view('frontend.content-report.EXCEL.monthCredoReport', compact('type', 'Tdate', 'Fdate', 'flag'));
            } elseif ($request->report == 'ScoreCredo') {
                $user_zone = auth()->user()->zone;
                $data = Data_Customer::where('UserZone', $user_zone)
                    ->whereBetween(DB::raw('CONVERT(date, created_at)'), [$Fdate, $Tdate])
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
            } elseif ($request->report == 'monthlyPA') {
                return view('frontend.content-report.EXCEL.monthPaReport', compact('type', 'Tdate', 'Fdate', 'flag'));
            }elseif ($request->report == 'credofragments'){
                $u_zone = auth()->user()->zone;
                    $Fdate = $request->Fdate;
                    $Tdate = $request->Tdate;

                $data = Data_CredoFragments::whereRaw("cast(uploadDate as date) between '".$Fdate."' and  '".$Tdate."'" )->get();
                return view('frontend.content-report.EXCEL.monthCredoFragment', compact('data', 'Tdate', 'Fdate'));

            }elseif ($request->report == 'PPbyTraget'){
                $u_zone = auth()->user()->zone;
                    $Fdate = $request->Fdate;
                    $Tdate = $request->Tdate;
                    $splitDate = explode('-',$Fdate);
                    $yearMonth= $splitDate[0]."-".$splitDate[1];
                    $month = $splitDate[1];
                    $year = $splitDate[0];

                    // $fdate = Carbon::parse('2024-03-01');
                    // $ldate = $fdate->copy()->endOfMonth();
                    // $week = $ldate->weekOfMonth;

                $week = DB::select("
                            SELECT
                                DATEPART(WEEK, dateSelect) AS weekly
                                ,COUNT(CASE WHEN DATEPART(dw, dateSelect) NOT IN (1) THEN 1 END) AS dayweek

                            FROM
                                (SELECT DATEADD(DAY, number, '".$yearMonth."-1') AS dateSelect
                                FROM master..spt_values
                                WHERE type = 'P' AND number <= DAY(EOMONTH('".$yearMonth."-1'))-1   ) as chkDate
                                GROUP BY DATEPART(WEEK, dateSelect)
                        ");


                // PPยอดจัด
                $data = DB::select("
                    with tb1 as(
                        SELECT a.Groups_id, d.id, d.Name_Branch,
                        SUM(CASE WHEN c.Buy_PA = 'yes' AND c.Include_PA = 'yes' THEN
                            CASE WHEN c.StatusProcess_Car = 'yes' THEN   c.Cash_Car + c.Process_Car +c.Insurance_PA
                            ELSE c.Cash_Car +c.Insurance_PA  END
                            ELSE CASE WHEN c.StatusProcess_Car = 'yes' THEN c.Cash_Car + c.Process_Car
                            ELSE c.Cash_Car END
                            END
                        ) AS Amount,DATEPART(WEEK, b.Date_monetary)  AS weekly
                        FROM TB_GroupLists a

                        LEFT JOIN  Pact_Contracts b on b.BranchSent_Con = a.listBranch_id
                        LEFT JOIN  Data_CusTagCalculates c ON c.datatag_id = b.DataTag_id
                        LEFT JOIN TB_Branchs d ON d.id = b.BranchSent_Con

                        WHERE FORMAT(CAST(b.Date_monetary AS DATE),'yyyy-MM') = '". $yearMonth ."' AND b.UserZone = '". $u_zone ."'
                        AND  b.Date_monetary between b.Date_monetary and  case when a.deleted_at IS Not NULL THEN a.deleted_at else GETDATE() end
                        GROUP BY a.Groups_id, d.id, d.Name_Branch, DATEPART(WEEK, b.Date_monetary)
                        ),
                        weeks as(
                                SELECT
                                DATEPART(WEEK, dateSelect) AS weekly
                                ,COUNT(CASE WHEN DATEPART(dw, dateSelect) NOT IN (1) THEN 1 END) AS dayweek

                                FROM
                                (SELECT DATEADD(DAY, number, '". $yearMonth ."-1') AS dateSelect
                                FROM master..spt_values
                                WHERE type = 'P' AND number <= DAY(EOMONTH('". $yearMonth ."-1'))-1) as chkDate
                                GROUP BY DATEPART(WEEK, dateSelect)
                        ),
                        tb2 as(
                                SELECT a.Groups_id, b.Target_Branch, FLOOR(SUM(b.Target_Amount)/(select COUNT(weekly) from weeks)) AS amont
                                FROM  TB_GroupLists a
                                LEFT JOIN TB_TargetAmount b ON b.Target_Branch =  a.listBranch_id
                                LEFT JOIN TB_TypeTarget c ON b.TypeTarget_id = c.id
                                WHERE
                                b.Target_Zone = '". $u_zone ."'  AND c.Target_Code = 'TR-0002'
                                AND '". intval($month) ."' IN (SELECT value FROM STRING_SPLIT(b.Target_month, ',')) AND b.Target_year = '". $year ."'
                                GROUP BY  b.Target_Branch ,a.Groups_id
                            )
                        SELECT  c.groupName as zone_sup,a.id ,a.Name_Branch,sum(a.Amount) as totAmont,a.weekly,sum(b.amont) as totTraget,e.dayweek
                            FROM tb1 a
                            LEFT JOIN tb2 b ON b.Target_Branch = a.id
                            LEFT JOIN TB_Groups c ON c.id = b.Groups_id AND '2' IN (SELECT value FROM STRING_SPLIT(c.groupType, ','))
                            LEFT join weeks e on a.weekly=e.weekly
                            group by c.groupName,a.id,a.Name_Branch ,  a.Amount,b.amont, e.dayweek, a.weekly order by  a.weekly
                    ");


                    $zoneSup = DB::select("
                    WITH weeks as(
                        SELECT
                                DATEPART(WEEK, dateSelect) AS weekly
                                ,COUNT(CASE WHEN DATEPART(dw, dateSelect) NOT IN (1) THEN 1 END) AS dayweek

                                FROM
                                (SELECT DATEADD(DAY, number, '". $yearMonth ."-1') AS dateSelect
                                FROM master..spt_values
                                WHERE type = 'P' AND number <= DAY(EOMONTH('". $yearMonth ."-1'))-1   ) as chkDate
                                GROUP BY DATEPART(WEEK, dateSelect)
                        )
                        SELECT  e.groupName as zone_sup,d.Name_Branch, b.Target_Branch, FLOOR(SUM(b.Target_Amount)/(SELECT COUNT(weekly) FROM weeks)) AS amont
                                FROM TB_GroupLists a
                                LEFT JOIN TB_TargetAmount b ON b.Target_Branch = a.listBranch_id
                                LEFT JOIN TB_TypeTarget c ON b.TypeTarget_id = c.id
                                LEFT JOIN   TB_Branchs d ON d.id = b.Target_Branch
                                LEFT JOIN TB_Groups e ON e.id = a.Groups_id AND '2' IN (SELECT value FROM STRING_SPLIT(e.groupType, ','))
                        WHERE
                                b.Target_Zone = '". $u_zone ."'
                                AND c.Target_Code = 'TR-0002'
                                AND '". intval($month) ."' IN (SELECT value FROM STRING_SPLIT(b.Target_month, ',')) AND b.Target_year = '". $year ."'
                        GROUP BY
                                b.Target_Branch,d.Name_Branch ,e.groupName order by e.groupName
                    ");

                    $arrData = [];
                    foreach ($data as $key => $value) {
                        $arrData2 = [];
                        $arrData2[] = $value->totAmont;
                        $arrData2[] = $value->totTraget;
                        $arrData2[] = $value->id;
                        $arrData[$value->weekly][$value->id] = $arrData2;
                    }
            //  dd($arrData);
             //pptarget
             $dataPP = DB::select("
                    with tb1 as(
                        select  a.Groups_id,c.id,c.Name_Branch,COUNT(c.Name_Branch) as countPP,
                        SUM(case when b.flag_reject ='y' then 1 else 0 end) as pp1day  ,  DATEPART(WEEK, b.date_tag)  AS weekly
                        from   TB_GroupLists a
                        left join Data_CusTags b on b.BranchCont = a.listBranch_id
                        left join TB_Branchs c on c.id= b.BranchCont

                        where format(cast(b.date_Tag as date),'yyyy-MM')=  '". $yearMonth ."' AND b.UserZone = '". $u_zone ."'
                        AND  b.date_Tag between b.date_Tag and  case when a.deleted_at IS Not NULL THEN a.deleted_at else GETDATE() end
                        group by  a.Groups_id,c.id,c.Name_Branch,DATEPART(WEEK, b.date_tag)
                        ),
                    weeks as(
                    SELECT
                    DATEPART(WEEK, dateSelect) AS weekly
                    ,COUNT(CASE WHEN DATEPART(dw, dateSelect) NOT IN (1) THEN 1 END) AS dayweek

                    FROM
                    (SELECT DATEADD(DAY, number, '". $yearMonth ."-1') AS dateSelect
                    FROM master..spt_values
                    WHERE type = 'P' AND number <= DAY(EOMONTH('". $yearMonth ."-1'))-1   ) as chkDate
                    GROUP BY DATEPART(WEEK, dateSelect)
                    ),
                        tb2 as(
                        SELECT a.Groups_id, b.Target_Branch,
                                ( b.Target_Amount/(select SUM(dayweek) from weeks)) as targetDay
                                FROM  TB_GroupLists a

                            LEFT JOIN TB_TargetAmount b ON b.Target_Branch = a.listBranch_id
                            LEFT JOIN TB_TypeTarget c ON b.TypeTarget_id = c.id

                                WHERE
                                    b.Target_Zone  = '". $u_zone ."'
                                    AND c.Target_Code = 'TR-0001'
                                    AND '". intval($month) ."' IN (SELECT value FROM STRING_SPLIT(b.Target_month, ',')) AND b.Target_year = '". $year ."'
                                GROUP BY
                                b.Target_Branch ,a.Groups_id, b.Target_Amount
                        ),
                        tb3 as(
                            select a.BranchSent_Con ,COUNT(a.Contract_Con) as booking  from Pact_Contracts a
                            where format(cast(a.Date_monetary as date),'yyyy-MM') =  '". $yearMonth ."'
                            group by a.BranchSent_Con
                        )
                                SELECT  d.groupName as zone_sup,a.id ,a.Name_Branch,sum(a.countPP) as totPP, SUM(c.booking) as booking , FLOOR(b.targetDay*e.dayweek) as totTraget,SUM(a.pp1day) as pp1day ,a.weekly,e.dayweek,b.targetDay
                                        FROM tb1 a
                                        LEFT JOIN tb2 b ON b.Target_Branch = a.id
                                        LEFT JOIN tb3 c ON c.BranchSent_Con = a.id
                                        LEFT JOIN TB_Groups d ON d.id = b.Groups_id AND '2' IN (SELECT value FROM STRING_SPLIT(d.groupType, ','))
                    LEFT join weeks e on a.weekly=e.weekly
                    group by d.groupName,a.id,a.Name_Branch ,  a.countPP,c.booking,FLOOR(b.targetDay*e.dayweek),a.pp1day ,a.weekly,e.dayweek,b.targetDay order by  a.weekly
                ");

                $arrDatapp = [];
                foreach ($dataPP as $key => $value) {
                    $arrDatapp2 = [];
                    $arrDatapp2[] = $value->totPP;
                    $arrDatapp2[] = $value->booking;
                    $arrDatapp2[] = $value->totTraget;
                    $arrDatapp2[] = $value->pp1day;
                    $arrDatapp[$value->weekly][$value->id] = $arrDatapp2;

                }


                $zoneSupPP = DB::select("
                WITH weeks as(
                    SELECT
                            DATEPART(WEEK, dateSelect) AS weekly
                            ,COUNT(CASE WHEN DATEPART(dw, dateSelect) NOT IN (1) THEN 1 END) AS dayweek

                            FROM
                            (SELECT DATEADD(DAY, number, '". $yearMonth ."-1') AS dateSelect
                            FROM master..spt_values
                            WHERE type = 'P' AND number <= DAY(EOMONTH('". $yearMonth ."-1'))-1   ) as chkDate
                            GROUP BY DATEPART(WEEK, dateSelect)
                    )
                    SELECT  e.groupName as zone_sup,d.Name_Branch, b.Target_Branch, FLOOR(SUM(b.Target_Amount)/(SELECT COUNT(weekly) FROM weeks)) AS amont
                            FROM   TB_GroupLists a
                            LEFT JOIN TB_TargetAmount b ON b.Target_Branch =  a.listBranch_id
                            LEFT JOIN TB_TypeTarget c ON b.TypeTarget_id = c.id
                            LEFT JOIN  TB_Branchs d ON d.id = b.Target_Branch
                            LEFT JOIN TB_Groups e ON e.id = a.Groups_id AND '2' IN (SELECT value FROM STRING_SPLIT(e.groupType, ','))
                    WHERE
                            b.Target_Zone = '40'
                            AND c.Target_Code = 'TR-0001'
                            AND '". intval($month) ."' IN (SELECT value FROM STRING_SPLIT(b.Target_month, ',')) AND b.Target_year = '". $year ."'
                    GROUP BY
                            b.Target_Branch,d.Name_Branch ,e.groupName order by e.groupName
                ");
            //dd($arrDatapp);
                return view('frontend.content-report.EXCEL.monthPPTarget', compact( 'arrData','zoneSup','arrDatapp','zoneSupPP','Tdate', 'Fdate','week'));

            }

        } elseif ($request->type == '8') {  // Asset List

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
            }


        } elseif ($request->type == 'Quatation') {      //Quatation
            $data = Data_CusTags::where('id', $request->id)->first();

            $type = $request->type;
            $view = \View::make('frontend.content-report.PDF.quotations', compact('data', 'type'));
            $html = $view->render();

            $pdf = new PDF();
            $pdf::SetTitle('ใบเสนอราคา');
            $pdf::AddPage("P", 'A4');
            $pdf::SetMargins(5, 5, 5, 5);
            $pdf::SetFont('thsarabun', '', 16, '', true);
            $pdf::SetAutoPageBreak(TRUE, 10);
            $pdf::WriteHTML($html, true, false, true, false, '');

            $pdf::Output('report.pdf');
        } elseif ($request->report == 'LoanContract') { // ฟอร์มสัญญา
            $user_zone = auth()->user()->zone;
            $PactCon_id = $request->PactCon_id;
            $data = Pact_Contracts::where('id', $id)->first();
            if (in_array($data->CodeLoan_Con, ['04', '10', '15', '16', '18'])) {
                $type = $request->type;
                // $view = \View::make('frontend.content-report.PDF.Form.FormLandContractBlank', compact('data', 'type'));
                // $html = $view->render();

                $view = \View::make('frontend.content-report.PDF.Form.FormLandContractBlankNew', compact('data', 'type'));

                $html = $view->render();

                // if(!empty($data->ContractToGuarantor)){
                //     foreach($data->ContractToGuarantor as $guard){
                //         $view = \View::make('frontend.content-report.PDF.Form.FormLandGuardBlank', compact('data','guard', 'type'));
                //         $html .= $view->render();
                //     }

                // }

                if(!empty($data->ContractToGuarantor)){
                    foreach($data->ContractToGuarantor as $guard){
                        $view = \View::make('frontend.content-report.PDF.Form.FormLandGuardBlankNew', compact('data','guard', 'type'));
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
            }else if(in_array($data->CodeLoan_Con, ['11', '12', '13', '17'])){
                $type = $request->type;
                // $view = \View::make('frontend.content-report.PDF.Form.FormPersonContractBlank', compact('data', 'type'));
                // $html = $view->render();

                $view = \View::make('frontend.content-report.PDF.Form.FormPersonContractBlankNew', compact('data', 'type'));
                $html = $view->render();
                //$pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
                if(!empty($data->ContractToGuarantor)){
                    foreach($data->ContractToGuarantor as $guard){
                        $view = \View::make('frontend.content-report.PDF.Form.FormPersonGuardBlank', compact('data','guard', 'type'));
                        $html .= $view->render();
                    }

                }


                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
                $pdf->setPaper('a4', 'portrait');



                return $pdf->stream();
            }

        } elseif ($request->report == 'Letter') { // จดหมาย
            $user_zone = auth()->user()->zone;
            $PactCon_id = $request->PactCon_id;
            $data = Pact_Contracts::where('id', $id)->first();
            $type = $request->type;
            $view = \View::make('frontend.content-report.PDF.Form.FormAdvice', compact('data', 'type'));
            $html = $view->render();
            // $pdf = new PDF();
            // $pdf::SetTitle('ใบสัญญากู้ยืม');
            // $pdf::AddPage("P",'A4');
            // $pdf::SetMargins(5, 5, 5, 0);
            // $pdf::SetFont('thsarabun', '', 14, '', true);
            // $pdf::SetAutoPageBreak(true,20);
            // $pdf::WriteHTML($html, true, false, true, false, '');
            // $pdf::Output('report.pdf');
            //4.25 * 9.125
            // 1 inch = 72 point
            // 1 inch = 2.54 cm
            // 10 cm = 10/2.54*72 = 283.464566929
            // 20 cm = 10/2.54*72 = 566.929133858
            $customPaper = array(0, 0, 306, 657);
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
            $pdf->setPaper('a4', 'landscape');
            return $pdf->stream();


        } elseif ($request->form == 'audit') {
            if ($request->report == 'statusDoc') {
                $u_zone = auth()->user()->zone;
                $Fdate = $request->Fdate;
                $Tdate = $request->Tdate;

                $data = DB::select(DB::raw("with tagPart as(
                    select d.Name_Branch,
                    sum(case when b.Status_TrackPart = '2' then 1 else 0 end) as received
                    from Pact_Contracts a
                    left join Pact_AuditTagparts b on a.id =b.PactCon_id
                    left join TB_StatusAudits  c on c.id  = b.Status_TrackPart
                    left join TB_Branchs d on d.id = a.BranchSent_Con
                    where FORMAT(cast(a.Date_monetary as date),'yyyy-MM-dd') between '" . $Fdate . "' and '" . $Tdate . "'
                    group by d.Name_Branch
                ),
                reject as (
                    select d.Name_Branch,
                    sum(case when b.Status_TrackPart = '4' then 1 else 0 end) as rejected
                    from Pact_Contracts a
                    left join Pact_AuditTagparts b on a.id =b.PactCon_id
                    left join TB_StatusAudits  c on c.id  = b.Status_TrackPart
                    left join TB_Branchs d on d.id = a.BranchSent_Con
                    where FORMAT(cast(a.Date_monetary as date),'yyyy-MM-dd') between '" . $Fdate . "' and '" . $Tdate . "'
                    group by d.Name_Branch
                )

                select d.Name_Branch, COUNT(d.Name_Branch) as numCon, e.received,
                sum(case when b.Flag_Status = '1' then 1 else 0 end) as delivered,
                sum(case when b.Flag_Status = '2' then 1 else 0 end) as receivedoff,
                sum(case when b.Flag_Status = '3' then 1 else 0 end) as check_documents,
                sum(case when b.Flag_Status = '4' then 1 else 0 end) as rejects,
                sum(case when b.Flag_Status = '5' then 1 else 0 end) as edited,
                sum(case when b.Flag_Status = '6' then 1 else 0 end) as complete,
                sum(case when b.Flag_Status = '7' then 1 else 0 end) as Filing,
                f.rejected ,sum(case when a.Flag_Reject = 'y' then 1 else 0 end) as rejectedSend
                from Pact_Contracts a
                left join Pact_AuditTags b on a.id =b.PactCon_id
                left join TB_StatusAudits  c on c.id  = b.Flag_Status
                left join TB_Branchs d on d.id = a.BranchSent_Con
                left join tagPart e on e.Name_Branch = d.Name_Branch
                left join reject f on f.Name_Branch = d.Name_Branch
                where FORMAT(cast(a.Date_monetary as date),'yyyy-MM-dd') between '" . $Fdate . "' and '" . $Tdate . "'
                and a.userZone = '" . $u_zone . "'
                group by d.Name_Branch ,e.received , f.rejected order by d.Name_Branch asc"));

                return view('frontend.content-report.EXCEL.statusAuditReport', compact('data', 'Fdate'));
            } elseif ($request->report == 'statusDocCheck') {
                $u_zone = auth()->user()->zone;
                $Fdate = $request->Fdate;
                $Tdate = $request->Tdate;
                $statusTxt = $request->statusTxt;
                $data = DB::table('View_ContractAuditEx1')
                    ->where('UserZone', $u_zone)
                    ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween('date_TrackPart', [$Fdate, $Tdate]);
                    })
                    ->when($statusTxt != 'all', function ($q) use ($statusTxt) {
                        return $q->where('Flag_Status', $statusTxt != '' ? $statusTxt : NULL);
                    })
                    ->whereNotNull('Date_monetary')
                    ->orderBy('CodeLoan_Con')
                    ->get();


                return view('frontend.content-report.EXCEL.AuditReport', compact('data', 'Fdate'));
            }


        } elseif ($request->form == 'commission') {
            $month = substr($request->Month, 0, 2);
            $year = substr($request->Month, 3, 4);

            // $data = DB::select('SELECT Date_monetary,Name_Branch,Loan_Name,
            //     Cash_Car,Process_Car,StatusProcess_Car,PA,CodeLoan_Con,id_rateType,Status_Con,UserZone,StatusCus_name,
            //     Buy_PA,GroupCus,Contract_Con
            //     FROM View_ReportConData WHERE UserZone = ' . auth()->user()->zone . ' AND MONTH(Date_monetary) = ' . $month . ' AND YEAR(Date_monetary) = ' . $year);

            $data = View_ReportConData::where('UserZone', auth()->user()->zone)
                ->whereMonth('Date_monetary', $month)
                ->whereYear('Date_monetary', $year)
                ->select(
                    'Date_monetary',
                    'Name_Branch',
                    'Loan_Name',
                    'Cash_Car',
                    'Process_Car',
                    'StatusProcess_Car',
                    'PA',
                    'CodeLoan_Con',
                    'id_rateType',
                    'Status_Con',
                    'UserZone',
                    'StatusCus_name',
                    'Buy_PA',
                    'GroupCus',
                    'Contract_Con',
                    'BranchSent_Con'
                )
                ->get();

            $Loans = TB_TypeLoanCom::where('Flag_Zone', auth()->user()->zone)
                ->pluck('Loan_Name')
                ->toArray();

            $roleNames = ['finances', 'staff'];
            $users = User::where('zone', auth()->user()->zone)
                ->whereHas('roles', function ($query) use ($roleNames) {
                    $query->whereIn('name', $roleNames);
                })
                ->select('branch', 'name', 'id')
                ->with('roles:name')
                ->get();

            $branchs = TB_Branchs::where('Branch_Active', 'yes')
                ->where('Zone_Branch', auth()->user()->zone)
                ->whereIn('id', function ($query) use ($users) {
                    $query->select('branch')
                        ->from('users')
                        ->whereIn('id', $users->pluck('id')->toArray());
                })
                ->select('id', 'Name_Branch')
                ->get();

            return view('frontend.content-report.EXCEL.Commission', compact('data', 'Loans', 'branchs', 'users'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
