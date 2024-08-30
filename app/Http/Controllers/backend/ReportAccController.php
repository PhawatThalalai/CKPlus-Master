<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_Constants\TB_Frontend\TB_TypeLoanCom;
use App\Models\TB_Constants\TB_Frontend\TB_Zone;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Barryvdh\DomPDF\Facade\Pdf as domPDF;
use ConnectCredo;
use PDF;
use Carbon\Carbon;
use App\Models\TB_temp\TMP_STOPVAT\TMP_STOPVATHP;
use App\Models\TB_temp\TMP_STOPVAT\TMP_STOPVATPSL;
use App\Traits\UserApproved;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;


use setasign\Fpdi\Fpdi;
use ZipArchive;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use iio\libmergepdf\Merger;
use iio\libmergepdf\Pages;

class ReportAccController extends Controller
{
    use UserApproved;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dump($request->all());
        $TypeLoan = TB_TypeLoanCom::generateQuery();
        $dataBranchs = TB_Branchs::generateQuery();
        $dataZone = TB_Zone::get();
        $dataEmpy =  $this->getUserFianacial();
        $form = $request->form;
        $report = $request->report;
        $popup = $request->popup;
        $reportTitle = $request->reportTitle;

        return view('backend.content-report.viewReport', compact('form', 'report', 'TypeLoan', 'dataBranchs','popup','reportTitle', 'dataZone', 'dataEmpy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $u_zone = auth()->user()->zone;
        $Loans = explode("-", $request->TypeLoans);
        $codeLoans = @$Loans[0];
        $nameLoans = @$Loans[1];
        $typeLoan = @$request->typeLoan;
        $Fdate = @$request->Fdate;
        $Tdate = @$request->Tdate;
        $Branch = @$request->Branch_Con;
        $Contno = @$request->CONTNO;
        $Status = @$request->Status_Con;
        $TypeLoans = @$request->TypeLoans;
        $report = @$request->report;
        $Zone_Con = @$request->Zone_Con;
        $tableLoan = @$request->tableLoan === null ? $request->TypeLoans : $request->tableLoan;
        $typeReport = @$request->typeReport  === null ? $request->export_type : $request->typeReport;
        $empy = @$request->empy;

        $userZone = User::where('zone', $u_zone)->withTrashed()->pluck('name', 'id')->all();

        $branchsAll = TB_Branchs::where('Zone_Branch', auth()->user()->zone)
        ->pluck('Name_Branch','id' )->toArray();
         
        $now = Carbon::now('Asia/Bangkok');
        $datePrint = $now->toDateTimeString();

        $timestamp_F = strtotime($Fdate);
        $Fdate_format = date('Y-m-d', $timestamp_F);
        $timestamp_T = strtotime($Tdate);
        $Tdate_format = date('Y-m-d', $timestamp_T);
        $month = date('Y-m', strtotime($Fdate));


        if ($request->report == 'reportBOT') {
            $Company_Id = '0815559000291';
            $dateMonth = '2024-01-31';
            return view('backend.content-report.EXCEL.botReport', compact('Company_Id', 'dateMonth'));
        }

        if($request->form =='Account'){
            if($request->report == 'ApproveLoan'){ // จัดในเดือน
                $table = '';
                if($tableLoan=='PSL'){
                    $table ='View_AccPSLCon_Month';
                }else{
                    $table ='View_AccHPCon_Month';
                }

                $data = DB::table($table)->whereRaw("cast(SDATE as date) between '".$Fdate_format."' and  '".$Tdate_format."'")
                        ->when(!empty($Branch), function ($q) use ($Branch) {
                            return $q->where('LOCAT', $Branch);
                        })
                        ->when(!empty($codeLoans), function ($q) use ($codeLoans) {
                            return $q->where('TYPECON', $codeLoans);
                        })
                        ->where('UserZone',$u_zone)->get();
                        //pdf

                if(count($data) !== 0){
                    if($typeReport == 'PDF'){
                        $options = new Options();
                       $options->set('isHtml5ParserEnabled', true);
                       $options->set('isPhpEnabled', true);
                       $options->set('isRemoteEnabled', true);
                       $options->set('defaultFont',  asset('fonts/TF Pimpakarn.ttf') );

                       $dompdf =  new  Dompdf($options);
                       if($tableLoan=='PSL'){
                           $view = View::make('backend.content-report.PDF.Accounts.granting_creditLoan', compact('data','Fdate','Tdate'));
                       }else{
                           $view = View::make('backend.content-report.PDF.Accounts.granting_creditLeasing', compact('data','Fdate','Tdate'));
                       }

                       $html = $view->render();
                       $dompdf->set_paper('A4', 'landscape');
                       $dompdf->loadHTML( $html);
                       $dompdf->render();
                       $dompdf->stream('my.pdf',array('Attachment'=>0));
                      } else{
                       return View('backend.content-report.EXCEL.Accounts.granting_credit', compact('data', 'tableLoan','Fdate','Tdate'));
                      }
                } else {
                    return view('components.content-alert.export-err');
                }
            } else if($request->report == 'Debtor') { // หยุดรับรู้รายได้ + vat
                    $locat = $request->branch_no ;
                    if($tableLoan == 'PSL') {
                        $response = TMP_STOPVATPSL::
                        when($locat != NULL ,function($query) use ($locat){
                            return $query->where("LOCAT",$locat);
                        })
                        ->whereRaw("  STOPVDT between '". $Fdate_format ."' and '". $Tdate_format ."'  AND UserZone  = '". $u_zone ."'")->get();
                    } else {
                        $response = TMP_STOPVATHP::
                        when($locat != NULL ,function($query) use ($locat){
                            return $query->where("LOCAT",$locat);
                        })
                         ->whereRaw(" STOPVDT between '". $Fdate_format ."' and '". $Tdate_format ."'  AND UserZone  = '". $u_zone ."'")->get();
                    }

                if(count($response) !== 0) {
                    if($typeReport == 'PDF') {
                        $options = new Options();
                        $options->set('isHtml5ParserEnabled', true);
                        $options->set('isPhpEnabled', true);
                        $options->set('isRemoteEnabled', true);
                        $options->set('defaultFont',  asset('fonts/TF Pimpakarn.ttf') );
                        $dompdf =  new  Dompdf($options);

                        $view = View::make('backend.content-report.PDF.Debtors.debtor-stopincome', compact('tableLoan', 'response'));

                        $html = $view->render();
                        $dompdf->setPaper('A4', 'portrait');
                        $dompdf->loadHTML( $html);
                        $dompdf->render();
                        $dompdf->stream('my.pdf',array('Attachment'=>0));
                    } else {
                        return View('backend.content-report.EXCEL.Debtors.debtor-stopincome', compact('tableLoan', 'response','Fdate','Tdate'));
                    }
                } else {
                    return view('components.content-alert.export-err');
                }
            } else if($request->report == "Payment") { // รับชำระ
                    $RequestZone = $request->zone!=NULL?$request->zone:$u_zone;
                    if($request->tax == 'sumPay') {
                        $data = DB::table("View_PaymentReport")
                        ->selectRaw("blpay,payby,PAYFOR, count(PAYFOR) as CPAYFOR,SUM(payamt) as payamt,
                        sum(PAYAMT_N) as PAYAMT_N,SUM(PAYAMT_V) as PAYAMT_V,SUM(DISCT) as DISCT
                        ,SUM(PAYINT) as PAYINT, SUM(DSCINT) as DSCINT, SUM(PAYFL) as PAYFL, SUM(DSCPAYFL) AS DSCPAYFL
                        , SUM(NETPAY) AS NETPAY")
                        ->whereBetween("TMBILDT",[$Fdate_format,$Tdate_format])
                        ->when($Branch != NULL ,function($query) use ($Branch){
                            return $query->where("LOCATREC",$Branch);
                        })
                        ->when($empy != NULL ,function($query) use ($empy){
                            return $query->where("UserInsert",$empy);
                        })
                        ->where('UserZone',$RequestZone)
                        // ->when($RequestZone != NULL ,function($query) use ($RequestZone){
                        //     return $query->where("UserZone",$RequestZone);
                        // })
                       
                        ->where("grouploan",$tableLoan)
                        ->where("flag",'<>','C');

                        $filteredData = $data->filter( function($item) {

                            return $item->blpay == $item->blpay; // Example condition: filter by age greater than 18
                        });

                        $groupedData = [];
                        foreach ($data as $item) {
                            $groupedData[$item->blpay][$item->payby][] = $item;
                        }

                        if(count($data) === 0) {
                            return view('components.content-alert.export-err');
                        }
                    } else {

                        $data2 = DB::table("View_PaymentReport")
                        ->selectRaw("blpay,payby,PAYFOR,TMBILL,TMBILDT,Name_Cus , CONTNO, payamt ,
                        PAYAMT_N , PAYAMT_V , DISCT,PAYINT,DSCINT,PAYFL,DSCPAYFL,NETPAY,flag, usinsert ,uscan,UserInsert,LOCATREC,Memo,created_at")
                        ->whereBetween("TMBILDT",[$Fdate_format,$Tdate_format])
                        ->when($Branch != NULL ,function($query) use ($Branch){
                            return $query->where("LOCATREC",$Branch);
                        })
                        ->where('UserZone',$RequestZone)
                        ->when($empy != NULL ,function($query) use ($empy){
                            return $query->where("UserInsert",$empy);
                        })
                        ->where("grouploan",$tableLoan)
                        // ->where("flag",'<>','C')
                        //->groupBy(["blpay","payby","PAYFOR","TMBILL","TMBILDT","Name_Cus"])
                        ->get();

                        $groupedData2 = [];
                        foreach ($data2 as $item) {
                            $groupedData2[$item->payby][] = $item;
                        }

                        if(count($data2) === 0) {
                            return view('components.content-alert.export-err');
                        }
                    }

                if($typeReport == 'PDF') {
                    Storage::delete('public/pdf/payment_zone-'. $u_zone .'.pdf');
                    $CalResponse = empty($data2) ? $data : $data2;
                     //การกำหนดกลุ่มข้อมูล
                    $numGroups = count($CalResponse) <= 750 ? 1 : 6;
                    //เอา data ทีได้จาก query มาหารกับกลุ่ม
                    $groupSize = ceil(count($CalResponse) / $numGroups);
                    $file_name = array();

                    // loop เพื่อสร้าง pdf ตามกลุ่ม
                    for ($i = 0; $i < count($CalResponse) ; $i++) {
                        $ArrayCount = $i;

                        // ถ้าจำนวนข้อมูลมากกว่า Size ของกลุ่ม ให้สร้างกลุ่มข้อมูลใหม่
                        if ($i % $groupSize == 0) {
                            unset($dataCut);
                        }

                        $dataCut[$i] = $CalResponse[$ArrayCount];

                        // ถ้าจำนวนข้อมูลเท่ากับ Size ของกลุ่ม ให้สร้าง pdf ของแต่ละกลุ่ม
                        if(($i + 1) % $groupSize == 0) {
                            $length = 16;
                            $bytes = random_bytes($length);
                            $Token = bin2hex($bytes);
                            if($request->tax == 'sumPay') {
                                $filteredData = $data->filter( function($item) {
                                    return $item->blpay == $item->blpay; // Example condition: filter by age greater than 18
                                });
                                $groupedData = [];
                                foreach ($dataCut as $item) {
                                    $groupedData[$item->blpay][$item->payby][] = $item;
                                }
                            } else {
                                $groupedData2 = [];
                                foreach ($dataCut as $item) {
                                    $groupedData2[$item->payby][] = $item;
                                }
                            }

                            $options = new Options();
                            $options->set('isHtml5ParserEnabled', true);
                            $options->set('isPhpEnabled', true);
                            $options->set('isRemoteEnabled', true);
                            $options->set('defaultFont',  asset('fonts/TF Pimpakarn.ttf') );

                            $dompdf =  new  Dompdf($options);

                            if ($request->tax == 'sumPay') {
                                $view = View::make('backend.content-report.PDF.Accounts.SumPaymentReport', compact('dataCut','groupedData','Fdate','Tdate','tableLoan'));
                            } else if ($request->tax == 'sumDetail') {
                                $view = View::make('backend.content-report.PDF.Accounts.SumPaymentReportDetail', compact('dataCut','groupedData2','Fdate','Tdate','tableLoan'));
                            } else if ($request->tax == 'payReport') {
                                $view = View::make('backend.content-report.PDF.Accounts.PaymentReport', compact('dataCut','groupedData2','Fdate','Tdate','tableLoan'));
                            }

                            $html = $view->render();
                            $dompdf->set_paper('A4', 'portrait');
                            $dompdf->loadHTML( $html);
                            $dompdf->render();
                            $output = $dompdf->output();
                            // เอาไฟล์ที่ได้มาเก็บไว้ใน path ที่ต้องการ
                            file_put_contents("storage/pdf/"."payment-arr-".$i."-".$Token.".pdf", $output);
                            //  ตัวแปรใช้เก็บ path ของไฟล์
                            $file_name[$i] = "payment-arr-".$i."-".$Token.".pdf";
                            // ล้าง memory ของ dompdf
                            $dompdf = null;
                            unset($dompdf);
                        }
                    }

                    // init ตัว merge package เพื่อรวม pdf
                    $merger = new Merger();

                    // เอาไฟล์ที่อยู่ใน array มา merge เข้าด้วยกัน
                    foreach ($file_name as $pdf) {
                        $pdfPath = storage_path('app/public/pdf/'. $pdf);
                        $merger->addFile($pdfPath);
                    }

                    // รวม pdf เข้าด้วยกัน
                    $mergedPdf = $merger->merge();
                    $outputPath = storage_path('app/public/pdf/payment_zone-'. $u_zone .'.pdf');
                    file_put_contents($outputPath, $mergedPdf);

                     // ลบไฟล์ที่อยู่ใน array ทิ้ง
                    foreach ($file_name as $file) {
                        Storage::delete('public/pdf/'. $file);
                    }

                    $outputFilePath = 'pdf/payment_zone-'. $u_zone .'.pdf';

                    // return func stream pdf กลับไป 
                    if (Storage::disk('public')->exists($outputFilePath)) {
                        return response()->stream(function () use ($outputFilePath) {
                            $stream = Storage::disk('public')->readStream($outputFilePath);
                            fpassthru($stream);
                        }, 200, [
                            'Content-Type' => 'application/pdf',
                            'Content-Disposition' => 'inline; filename="payment.pdf"',
                        ]);
                    } else {
                        abort(404, 'File not found.');
                    }
                } else {
                    return View('backend.content-report.EXCEL.Accounts.PaymentReport', compact('data2','Fdate','Tdate','tableLoan'));
                }
            } else if($request->report == 'Normaltax') { // tax
                $currentTime = Carbon::now();
                $response = DB::table('View_TxtTran')->whereRaw("TAXDT between '". $Fdate_format ."' and '". $Tdate_format ."' and userZone = '". $u_zone ."'")->get();

                if(count($response) !== 0) {
                    if($typeReport == 'PDF') {
                        $options = new Options();
                        $options->set('isHtml5ParserEnabled', true);
                        $options->set('isPhpEnabled', true);
                        $options->set('isRemoteEnabled', true);
                        $options->set('defaultFont',  asset('fonts/TF Pimpakarn.ttf') );

                        $dompdf =  new  Dompdf($options);

                        $view = View::make('backend.content-report.PDF.FormSalestax', compact('response','Fdate','Tdate','currentTime'));

                        $html = $view->render();
                        $dompdf->set_paper('A4', 'landscape');
                        $dompdf->loadHTML( $html);
                        $dompdf->render();
                        $dompdf->stream('my.pdf',array('Attachment'=>0));
                    } else {
                        return view('backend.content-report.EXCEL.Salestax', compact('response','Fdate','Tdate','currentTime'));
                    }
                } else {
                    return view('components.content-alert.export-err');
                }
            } else if($request->report == 'outstanding') { //Currrent long term
                if ($typeReport == 'PDF') {
                    $options = new Options();
                    $options->set('isHtml5ParserEnabled', true);
                    $options->set('isPhpEnabled', true);
                    $options->set('isRemoteEnabled', true);
                    $options->set('defaultFont',  asset('fonts/TF Pimpakarn.ttf') );

                    $dompdf =  new  Dompdf($options);

                    $view = View::make('backend.content-report.PDF.Formoutstanding');

                    $html = $view->render();
                    $dompdf->set_paper('A4', 'landscape');
                    $dompdf->loadHTML( $html);
                    $dompdf->render();
                    $dompdf->stream('my.pdf',array('Attachment'=>0));
                } else {
                    return View('backend.content-report.EXCEL.outstanding');
                }

            } else if($request->report == 'profit') {// รายงานกำไรคงเหลือ
                try {
                    $typeProfit = $request->typeProfit;
                    $conttype = $request->CONTTYPE;
                    $branchNew = $Branch==NULL?'%':$Branch;
                    $Contno_r =$Contno==NULL?'%':$Contno; 
                    if($tableLoan == 'PSL') {
                        if($conttype == '1') {
                            switch ($typeProfit) {
                                case 'profitFollowDate':

                                    $dataProfitfollow = DB::select('select * from utf_RepDueEffr(?,?,?,?,?);',[$branchNew,$Contno_r,$Fdate_format,$Tdate_format,$u_zone]);
                                   
                                    // $dataProfitfollow = DB::select("
                                    //     WITH dataDueAcc AS (
                                    //         SELECT a.CONTNO, 
                                    //         SUM(CASE WHEN a.DTSTOPV IS NULL THEN 
                                    //             CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM')< '". $month ."' THEN b.interest ELSE 0 END 
                                    //             ELSE 
                                    //             CASE WHEN b.DDATE < a.DTSTOPV THEN b.interest ELSE 0 END END) AS payintbefore, 

                                    //         SUM(CASE WHEN a.DTSTOPV IS NULL THEN 
                                    //                     CASE WHEN b.DDATE between '". $Fdate_format ."' and '". $Tdate_format ."' AND c.TMBILDT is null THEN b.interest ELSE 
                                    //                     CASE WHEN c.TMBILDT between '". $Fdate_format ."' and '". $Tdate_format ."'  AND b.DDATE >= '". $Fdate_format ."' then b.interest else 0  end
                                    //                     END 
                                    //                 WHEN a.DTSTOPV IS NOT NULL and c.TMBILDT is null  THEN 
                                    //                     CASE WHEN b.DDATE < a.DTSTOPV THEN 0 end else
                                    //                     case WHEN  c.TMBILDT between '". $Fdate_format ."' and '". $Tdate_format ."' AND b.DDATE >= a.DTSTOPV THEN b.interest end END) AS inteffmonth, 

                                    //         SUM(CASE WHEN a.DTSTOPV IS NULL  AND c.TMBILDT is null  THEN 
                                    //             CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM-dd') > '". $Tdate_format ."' THEN b.interest ELSE 0 END 
                                    //                 WHEN a.DTSTOPV IS NOT NULL AND a.TOTPRC - a.SMPAY > 0 THEN 
                                    //             CASE WHEN b.DDATE >= a.DTSTOPV THEN b.interest ELSE 0 END WHEN a.TOTPRC - a.SMPAY = 0 THEN 0 END) AS intbalance
                                    //             FROM      dbo.PatchPSL_Contracts AS a LEFT OUTER JOIN
                                    //                             dbo.PatchPSL_paydue  AS b ON a.CONTNO = b.contno
                                    //                             LEFT JOIN PatchPSL_CHQTran AS c ON a.CONTNO = c.contno AND c.PAYFOR = '007' and c.FLAG <>'C'
                                    //             WHERE   (a.capitalbl > 0 OR (format(CAST(a.LPAYD AS date), 'yyyy-MM-dd')  between '". $Fdate_format ."' and '". $Tdate_format ."') ) AND (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 1) 
                                                                
                                    //             GROUP BY a.CONTNO),
                                    //             duePay as (select a.CONTNO,
                                    //                     SUM(  d.DUEINTEFF ) AS dueIntAll
                                    //                         FROM      dbo.PatchPSL_Contracts AS a  
                                    //                                         left join dbo.PatchPSL_DUEPAYMENT  AS d ON a.CONTNO = d.contno
                                    //                                         LEFT JOIN PatchPSL_CHQTran AS c ON a.CONTNO = c.contno  
                                    //                         WHERE    (format(CAST(c.TMBILDT AS date), 'yyyy-MM-dd')  between '". $Fdate_format ."' and '". $Tdate_format ."') AND c.PAYFOR = '007' and c.FLAG <>'C'   AND (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 1) 
                                                                
                                    //                         GROUP BY a.CONTNO
                                                
                                    //         ),
                                    //         DateDue as (select a.CONTNO,d.DUEDATE
                                    //             FROM   dbo.PatchPSL_Contracts AS a  
                                    //                     left join dbo.PatchPSL_DUEPAYMENT  AS d ON a.CONTNO = d.contno								
                                    //             WHERE  (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 1)  and format(CAST(d.DUEDATE AS date), 'yyyy-MM-dd') between '". $Fdate_format ."' and '". $Tdate_format ."'                     
                                    //             GROUP BY a.CONTNO,d.DUEDATE	
                                    //         )

                                    //         SELECT a.locat, a.contno, a.CONTTYP, a.CODLOAN, a.Name_Cus, a.sdate, a.fdate, a.ldate, a.t_nopay, a.tcshprc, a.NETPROFIT, a.tot_upay, a.totprc, a.totprc - a.SMPAY AS Arbl, a.userzone, a.dataTable, a.DTSTOPV,
                                    //                         b.payintbefore, b.inteffmonth, b.intbalance ,ISNULL(c.dueIntAll,0) AS PAY,d.DUEDATE,e.DISCT
                                    //             FROM     dbo.VWBC_PatchContracts AS a 
                                    //                 LEFT OUTER JOIN  dataDueAcc AS b ON b.CONTNO = a.contno
                                    //                 LEFT OUTER JOIN  duePay AS c ON c.CONTNO = a.contno
                                    //                 LEFT OUTER JOIN  DateDue AS d ON d.CONTNO = a.contno
                                    //                 LEFT JOIN PatchPSL_CHQTran AS e ON a.CONTNO = e.contno  and e.FLAG <>'C' and PAYFOR ='007'
                                    //             WHERE  (a.capitalbl > 0   OR (format(CAST(a.LPAYD AS date), 'yyyy-MM-dd')  between '". $Fdate_format ."' and '". $Tdate_format ."')  ) 
                                    //             AND (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 1) and a.dataTable = 'PSL' and a.locat LIKE '".$branchNew."'
                                    // ");
                                break;
                                case 'profit':
                                    $dataProfit = DB::select("select * from utf_PSLProfBalEff(?,?,?,?)",[$branchNew,$Contno_r ,$Tdate_format,$u_zone]);
                                    // $dataProfit = DB::select("
                                    //     WITH dataDueAcc AS (
                                    //         SELECT a.CONTNO, 
                                    //         SUM( 
                                    //             CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM-dd')<='". $Tdate_format ."' THEN b.damt ELSE 0 END 
                                    //         ) AS sumDamt, 
                                    //         SUM( 
                                    //             CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM-dd')<= '". $Tdate_format ."' THEN b.interest ELSE 0 END 
                                    //         ) AS sumIntdue , 
                                    //         SUM( 
                                    //             CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM')< '". $month ."' THEN b.interest ELSE 0 END 
                                    //             ) AS payintbefore, 
                                            
                                    //         SUM(CASE WHEN b.DDATE between '". $Fdate_format ."' and '". $Tdate_format ."'  THEN b.interest ELSE 0 END 
                                    //                 ) AS inteffmonth, 
                                            
                                    //         SUM( 
                                    //             CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM-dd') > '". $Tdate_format ."' THEN b.interest ELSE 0 END 
                                    //             ) AS intbalance
                                    //             FROM      dbo.PatchPSL_Contracts AS a LEFT OUTER JOIN
                                    //                     dbo.PatchPSL_paydue  AS b ON a.CONTNO = b.contno
                                                                
                                    //             WHERE   (a.capitalbl > 0  ) AND (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 1) 
                                                                
                                    //             GROUP BY a.CONTNO
                                    //             ),
                                    //     duePay as(
                                    //     select a.CONTNO,
                                    //             SUM(	 
                                    //                 CASE WHEN  b.PAYAMT>0  THEN b.PAYINTEFF ELSE 0 END
                                    //                 ) AS sumPayInt,
                                    //             SUM( 
                                    //                 CASE WHEN  b.PAYAMT>0 THEN b.PAYAMT ELSE 0 END 
                                    //                 ) AS sumPayamt,
                                    //                 SUM( 
                                    //                 CASE WHEN  format(CAST(b.DUEDATE AS date), 'yyyy-MM-dd')<='". $Tdate_format ."' and b.DUEAMT-b.PAYAMT>0 THEN b.DUEINTEFF-b.PAYINTEFF ELSE 0 END 
                                    //                 ) AS sumKangInt
                                    //                 FROM      dbo.PatchPSL_Contracts AS a  
                                    //                         left join dbo.PatchPSL_DUEPAYMENT  AS b ON a.CONTNO = b.contno
                                    //                         LEFT JOIN PatchPSL_CHQTran AS c ON a.CONTNO = c.contno AND c.PAYFOR = '007' and c.FLAG <>'C'
                                    //                 WHERE (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 1) 
                                                        
                                    //                 GROUP BY a.CONTNO
                                    //                 )
                                    //     SELECT a.locat, a.contno, a.CONTTYP, a.CODLOAN, a.Name_Cus, a.sdate, a.fdate, a.ldate, a.t_nopay, a.tcshprc, a.NETPROFIT, a.tot_upay, a.totprc, a.totprc - a.SMPAY AS Arbl,a.capitalbl , a.userzone, a.dataTable, a.DTSTOPV,
                                    //             b.payintbefore, b.inteffmonth, b.intbalance ,b.sumDamt,b.sumIntdue ,ISNULL(c.sumPayamt,0) as sumPayamt  ,ISNULL(c.sumPayInt,0) as sumPayInt ,ISNULL(c.sumKangInt,0) as sumKangInt  ,a.EXP_AMT
                                    //             FROM     dbo.VWBC_PatchContracts AS a 
                                    //                 LEFT OUTER JOIN  dataDueAcc AS b ON b.CONTNO = a.contno
                                    //                 LEFT OUTER JOIN  duePay AS c ON c.CONTNO = a.contno
                                    //             WHERE  (a.tcshprc-(ISNULL(c.sumPayamt,0)-ISNULL(c.sumPayInt,0))> 0) 
                                    //             AND (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 1) and a.dataTable = 'PSL' and a.locat LIKE '".$branchNew."'
                                    // ");
                                break;
                            }
                        } else if ($conttype == '2') {
                            switch ($typeProfit) {
                                case 'profitFollowDate':
                                    $dataProfitfollow = DB::select('select * from utf_RepDueLand(?,?,?,?,?);',[$branchNew,$Contno_r,$Fdate_format,$Tdate_format,$u_zone]);
                                    // $dataProfitfollow = DB::select("
                                    //     WITH dataDueAcc AS (
                                    //     SELECT a.CONTNO, 
                                    //     SUM(CASE WHEN a.DTSTOPV IS NULL THEN 
                                    //         CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM')< '". $month ."' THEN b.interest ELSE 0 END 
                                    //         ELSE 
                                    //         CASE WHEN b.DDATE < a.DTSTOPV THEN b.interest ELSE 0 END END) AS payintbefore, 

                                    //     SUM(CASE WHEN a.DTSTOPV IS NULL THEN 
                                    //                 CASE WHEN b.DDATE between '". $Fdate_format ."' and '". $Tdate_format ."' AND c.TMBILDT is null THEN b.interest ELSE 
                                    //                 CASE WHEN c.TMBILDT between '". $Fdate_format ."' and '". $Tdate_format ."'  AND b.DDATE >= '". $Fdate_format ."' then b.interest else 0   end
                                    //                 END 
                                    //             WHEN a.DTSTOPV IS NOT NULL and c.TMBILDT is null THEN 
                                    //                 CASE WHEN b.DDATE < a.DTSTOPV THEN 0 end else
                                    //                 case WHEN  c.TMBILDT between '". $Fdate_format ."' and '". $Tdate_format ."' AND b.DDATE >= a.DTSTOPV THEN b.interest end END) AS inteffmonth, 

                                    //     SUM(CASE WHEN a.DTSTOPV IS NULL  AND c.TMBILDT is null  THEN 
                                    //         CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM-dd') > '". $Tdate_format ."' THEN b.interest ELSE 0 END 
                                    //             WHEN a.DTSTOPV IS NOT NULL AND a.TOTPRC - a.SMPAY > 0 THEN 
                                    //         CASE WHEN b.DDATE >= a.DTSTOPV THEN b.interest ELSE 0 END WHEN a.TOTPRC - a.SMPAY = 0 THEN 0 END) AS intbalance
                                    //         FROM      dbo.PatchPSL_Contracts AS a LEFT OUTER JOIN
                                    //                         dbo.PatchPSL_paydueLoan  AS b ON a.CONTNO = b.contno
                                    //                         LEFT JOIN PatchPSL_CHQTran AS c ON a.CONTNO = c.contno AND c.PAYFOR = '007' and c.FLAG <>'C'
                                    //         WHERE   (a.TOTPRC - a.SMPAY > 0 OR (format(CAST(a.LPAYD AS date), 'yyyy-MM-dd')  between '". $Fdate_format ."' and '". $Tdate_format ."') ) AND (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 2) 
                                                            
                                    //         GROUP BY a.CONTNO),
                                    //         duePay as (select a.CONTNO,
                                    //                 SUM(  d.interest ) AS dueIntAll
                                    //                     FROM      dbo.PatchPSL_Contracts AS a  
                                    //                                     left join dbo.PatchPSL_paydueLoan  AS d ON a.CONTNO = d.contno
                                    //                                     LEFT JOIN PatchPSL_CHQTran AS c ON a.CONTNO = c.contno  
                                    //                     WHERE    (format(CAST(c.TMBILDT AS date), 'yyyy-MM-dd')  between '". $Fdate_format ."' and '". $Tdate_format ."') AND c.PAYFOR = '007' and c.FLAG <>'C'   AND (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 2) 
                                                            
                                    //                     GROUP BY a.CONTNO
                                            
                                    //         ),
                                    //         DateDue as (select a.CONTNO,d.ddate
                                    //                     FROM   dbo.PatchPSL_Contracts AS a  
                                    //                             left join dbo.PatchPSL_paydueLoan  AS d ON a.CONTNO = d.contno								
                                    //                     WHERE  (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 2)  and format(CAST(d.ddate AS date), 'yyyy-MM-dd') between '". $Fdate_format ."' and '". $Tdate_format ."'                     
                                    //                     GROUP BY a.CONTNO,d.ddate	
                                    //         )

                                    //         SELECT a.locat, a.contno, a.CONTTYP, a.CODLOAN, a.Name_Cus, a.sdate, a.fdate, a.ldate, a.t_nopay, a.tcshprc, a.NETPROFIT, a.tot_upay, a.totprc, a.totprc - a.SMPAY AS Arbl, a.userzone, a.dataTable, a.DTSTOPV,
                                    //                         b.payintbefore, b.inteffmonth, b.intbalance ,ISNULL(c.dueIntAll,0) AS PAY,d.ddate,e.DISCT
                                    //         FROM     dbo.VWBC_PatchContracts AS a 
                                    //             LEFT OUTER JOIN  dataDueAcc AS b ON b.CONTNO = a.contno
                                    //             LEFT OUTER JOIN  duePay AS c ON c.CONTNO = a.contno
                                    //             LEFT OUTER JOIN  DateDue AS d ON d.CONTNO = a.contno
                                    //             LEFT JOIN PatchPSL_CHQTran AS e ON a.CONTNO = e.contno  and e.FLAG <>'C' and PAYFOR ='007'
                                    //         WHERE  (a.TOTPRC - a.SMPAY > 0   OR (format(CAST(a.LPAYD AS date), 'yyyy-MM-dd')  between '". $Fdate_format ."' and '". $Tdate_format ."')  ) 
                                    //         AND (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 2) and a.dataTable = 'PSL' and a.locat LIKE '".$branchNew."'
                                    // ");
                                break;
                                case 'profit':
                                    $dataProfit = DB::select("select * from utf_PSLProfBalLand(?,?,?,?)",[$branchNew,$Contno_r,$Tdate_format,$u_zone]);

                                    // $dataProfit = DB::select("
                                    //     WITH dataDueAcc AS (
                                    //         SELECT a.CONTNO, 
                                    //         SUM( 
                                    //             CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM-dd')<='". $Tdate_format ."' THEN b.damt ELSE 0 END 
                                    //         ) AS sumDamt, 
                                    //         SUM( 
                                    //             CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM-dd')<= '". $Tdate_format ."' THEN b.interest ELSE 0 END 
                                    //         ) AS sumIntdue , 
                                    //         SUM( 
                                    //             CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM')< '". $month ."' THEN b.interest ELSE 0 END 
                                    //             ) AS payintbefore, 
                                            
                                    //         SUM(CASE WHEN b.DDATE between '". $Fdate_format ."' and '". $Tdate_format ."'  THEN b.interest ELSE 0 END 
                                    //             ) AS inteffmonth, 
                                            
                                    //         SUM( 
                                    //             CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM-dd') > '". $Tdate_format ."' THEN b.interest ELSE 0 END 
                                    //             ) AS intbalance
                                    //             FROM      dbo.PatchPSL_Contracts AS a LEFT OUTER JOIN
                                    //                     dbo.PatchPSL_paydueLoan  AS b ON a.CONTNO = b.contno
                                                                
                                    //             WHERE   (a.capitalbl > 0  ) AND (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 2) 
                                                                
                                    //             GROUP BY a.CONTNO
                                    //     ),
                                    //     duePay as(
                                    //         select a.CONTNO,
                                    //         SUM(	 
                                    //             CASE WHEN  b.payment>0 and b.ddate<='". $Tdate_format ."' THEN b.V_PAYMENT ELSE 0 END
                                    //             ) AS sumPayInt,
                                    //         SUM( 
                                    //             CASE WHEN  b.payment>0 THEN b.payment ELSE 0 END 
                                    //             ) AS sumPayamt,
                                    //             SUM( 
                                    //             CASE WHEN  format(CAST(b.ddate AS date), 'yyyy-MM-dd')<='". $Tdate_format ."' and b.damt-b.payment>0 THEN b.interest-b.V_PAYMENT ELSE 0 END 
                                    //             ) AS sumKangInt
                                    //             FROM      dbo.PatchPSL_Contracts AS a  
                                    //             left join dbo.PatchPSL_paydueLoan AS b ON a.CONTNO = b.contno
                                    //             LEFT JOIN PatchPSL_CHQTran AS c ON a.CONTNO = c.contno AND c.PAYFOR = '007' and c.FLAG <>'C'
                                    //             WHERE (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 2) 
                                                            
                                    //             GROUP BY a.CONTNO
                                    //     )
                                    //     SELECT a.locat, a.contno, a.CONTTYP, a.CODLOAN, a.Name_Cus, a.sdate, a.fdate, a.ldate, a.t_nopay, a.tcshprc, a.NETPROFIT, a.tot_upay, a.totprc, a.totprc - a.SMPAY AS Arbl,a.capitalbl , a.userzone, a.dataTable, a.DTSTOPV,
                                    //         b.payintbefore, b.inteffmonth, b.intbalance ,b.sumDamt,b.sumIntdue ,ISNULL(c.sumPayamt,0) as sumPayamt  ,ISNULL(c.sumPayInt,0) as sumPayInt ,ISNULL(c.sumKangInt,0) as sumKangInt  ,a.EXP_AMT
                                    //         FROM     dbo.VWBC_PatchContracts AS a 
                                    //             LEFT OUTER JOIN  dataDueAcc AS b ON b.CONTNO = a.contno
                                    //             LEFT OUTER JOIN  duePay AS c ON c.CONTNO = a.contno
                                    //         WHERE  (a.capitalbl > 0 ) 
                                    //         AND (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 2) and a.dataTable = 'PSL' and a.locat LIKE '".$branchNew."'
                                    // ");
                                break;
                            }
                        } else if ($conttype == '3') {
                            switch ($typeProfit) {
                                case 'profitFollowDate':
                                    $dataProfitfollow = DB::select('select * from utf_RepDueLandShort(?,?,?,?,?);',[$branchNew,$Contno_r,$Fdate_format,$Tdate_format,$u_zone]);
                                    
                                    // $dataProfitfollow = DB::select("
                                    //     WITH dataDueAcc AS (
                                    //         SELECT a.CONTNO, 
                                    //         SUM( CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM')< '". $month ."' THEN b.interest ELSE 0 END 
                                    //             ) AS payintbefore, 
                                    //         SUM( CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM')< '". $month ."' THEN b.FEEINT ELSE 0 END 
                                    //             ) AS payintfee, 

                                    //         SUM( CASE WHEN b.DDATE between '". $Fdate_format ."' and '". $Tdate_format ."' AND c.TMBILDT is null THEN b.interest ELSE 
                                    //                     CASE WHEN c.TMBILDT between '". $Fdate_format ."' and '". $Tdate_format ."'  AND b.DDATE >= '". $Fdate_format ."' then b.interest else 0   end
                                    //                     END 
                                    //             ) AS inteffmonth, 
                                    //         SUM( CASE WHEN b.DDATE between '". $Fdate_format ."' and '". $Tdate_format ."' AND c.TMBILDT is null THEN b.FEEINT ELSE 
                                    //                     CASE WHEN c.TMBILDT between '". $Fdate_format ."' and '". $Tdate_format ."'  AND b.DDATE >= '". $Fdate_format ."' then b.FEEINT else 0   end
                                    //                     END 
                                    //             ) AS inteffmonthfee, 

                                    //         SUM( 
                                    //             CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM-dd') > '". $Tdate_format ."' THEN b.interest ELSE 0 END 
                                    //                 ) AS intbalance,
                                    //         SUM( 
                                    //             CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM-dd') > '". $Tdate_format ."' THEN b.FEEINT ELSE 0 END 
                                    //                 ) AS intbalancefee

                                    //             FROM      dbo.PatchPSL_Contracts AS a LEFT OUTER JOIN
                                    //                             dbo.PatchPSL_paydueLoan  AS b ON a.CONTNO = b.contno
                                    //                             LEFT JOIN PatchPSL_CHQTran AS c ON a.CONTNO = c.contno AND c.PAYFOR = '007' and c.FLAG <>'C'
                                    //             WHERE   (a.TOTPRC - a.SMPAY > 0 OR (format(CAST(a.LPAYD AS date), 'yyyy-MM-dd')  between '". $Fdate_format ."' and '". $Tdate_format ."') ) AND (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 3) 
                                                                
                                    //             GROUP BY a.CONTNO),
                                    //     duePay as (select a.CONTNO,
                                    //             SUM(
                                    //                 d.interest 
                                    //             ) AS dueIntAll,
                                    //             SUM(
                                    //                 CASE WHEN format(CAST(d.ddate AS date), 'yyyy-MM-dd')<= c.TMBILDT THEN d.FEEINT ELSE 0 END 
                                    //             ) AS dueIntFee
                                    //                 FROM      dbo.PatchPSL_Contracts AS a  
                                    //                                 left join dbo.PatchPSL_paydueLoan  AS d ON a.CONTNO = d.contno
                                    //                                 LEFT JOIN PatchPSL_CHQTran AS c ON a.CONTNO = c.contno  
                                    //                 WHERE    (format(CAST(c.TMBILDT AS date), 'yyyy-MM-dd')  between '". $Fdate_format ."' and '". $Tdate_format ."') AND c.PAYFOR = '007' and c.FLAG <>'C'   AND (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 3) 
                                                        
                                    //                 GROUP BY a.CONTNO
                                        
                                    //     ),
                                    //     DateDue as (select a.CONTNO,d.ddate
                                    //                 FROM   dbo.PatchPSL_Contracts AS a  
                                    //                         left join dbo.PatchPSL_paydueLoan  AS d ON a.CONTNO = d.contno								
                                    //                 WHERE  (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 3)  and format(CAST(d.ddate AS date), 'yyyy-MM-dd') between '". $Fdate_format ."' and '". $Tdate_format ."'                     
                                    //                 GROUP BY a.CONTNO,d.ddate	
                                    //     )

                                    //     SELECT a.locat, a.contno, a.CONTTYP, a.CODLOAN, a.Name_Cus, a.sdate, a.fdate, a.ldate, a.t_nopay, a.tcshprc, a.NETPROFIT, a.tot_upay, a.totprc, a.totprc - a.SMPAY AS Arbl, a.userzone, a.dataTable, a.DTSTOPV,
                                    //                     b.payintbefore, b.inteffmonth, b.intbalance,b.payintfee,b.inteffmonthfee,b.intbalancefee  ,ISNULL(c.dueIntAll,0) as dueIntAll,ISNULL(c.dueIntFee,0) as dueIntFee,d.ddate,e.DISCT
                                    //     FROM     dbo.VWBC_PatchContracts AS a 
                                    //         LEFT OUTER JOIN  dataDueAcc AS b ON b.CONTNO = a.contno
                                    //         LEFT OUTER JOIN  duePay AS c ON c.CONTNO = a.contno
                                    //         LEFT OUTER JOIN  DateDue AS d ON d.CONTNO = a.contno
                                    //         LEFT JOIN PatchPSL_CHQTran AS e ON a.CONTNO = e.contno  and e.FLAG <>'C' and PAYFOR ='007'
                                    //     WHERE  (a.TOTPRC - a.SMPAY > 0   OR (format(CAST(a.LPAYD AS date), 'yyyy-MM-dd')  between '". $Fdate_format ."' and '". $Tdate_format ."')  ) 
                                    //     AND (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 3) and a.dataTable = 'PSL' and a.locat LIKE '".$branchNew."'
                                    // ");
                                break;
                                case 'profit':
                                    $dataProfit = DB::select("select * from utf_PSLProfBalShort(?,?,?,?)",[$branchNew,$Contno_r,$Tdate_format,$u_zone]);

                                    // $dataProfit = DB::select("
                                    //     WITH dataDueAcc AS (
                                    //         SELECT a.CONTNO, 
                                    //         SUM( 
                                    //             CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM-dd')<='". $Tdate_format ."' THEN b.damt ELSE 0 END 
                                    //         ) AS sumDamt, 
                                    //         SUM( 
                                    //             CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM-dd')<= '". $Tdate_format ."' THEN b.interest ELSE 0 END 
                                    //         ) AS sumIntdue , 
                                    //         SUM( 
                                    //             CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM-dd')<= '". $Tdate_format ."' THEN b.FEEINT ELSE 0 END 
                                    //         ) AS sumIntdueFee , 
                                    //         SUM( 
                                    //             CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM')< '". $month ."' THEN b.interest ELSE 0 END 
                                    //             ) AS payintbefore, 
                                    //         SUM( 
                                    //             CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM')< '". $month ."' THEN b.FEEINT ELSE 0 END 
                                    //             ) AS payintbeforeFee, 
                                            
                                    //         SUM(CASE WHEN b.DDATE between '". $Fdate_format ."' and '". $Tdate_format ."'  THEN b.interest ELSE 0 END 
                                    //                 ) AS inteffmonth, 
                                    //         SUM(CASE WHEN b.DDATE between '". $Fdate_format ."' and '". $Tdate_format ."'  THEN b.FEEINT ELSE 0 END 
                                    //                 ) AS inteffmonthFee, 
                                            
                                    //         SUM( 
                                    //             CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM-dd') > '". $Tdate_format ."' THEN b.interest ELSE 0 END 
                                    //             ) AS intbalance,
                                    //         SUM( 
                                    //             CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM-dd') > '". $Tdate_format ."' THEN b.FEEINT ELSE 0 END 
                                    //             ) AS intbalanceFee
                                            
                                    //             FROM      dbo.PatchPSL_Contracts AS a LEFT OUTER JOIN
                                    //                     dbo.PatchPSL_paydueLoan  AS b ON a.CONTNO = b.contno
                                                                
                                    //             WHERE   (a.capitalbl > 0  ) AND (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 3) 
                                                                
                                    //             GROUP BY a.CONTNO
                                    //             ),
                                    //     duePay as(
                                    //     select a.CONTNO,
                                    //             SUM(	 
                                    //                 CASE WHEN  b.payment>0 and b.ddate<='". $Tdate_format ."' THEN b.V_PAYMENT ELSE 0 END				 
                                    //                 ) AS sumPayInt,
                                    //             SUM( 
                                    //                 CASE WHEN  b.payment>0 THEN b.payment ELSE 0 END 
                                    //                 ) AS sumPayamt,
                                    //                 SUM( 
                                    //                 CASE WHEN  format(CAST(b.ddate AS date), 'yyyy-MM-dd')<='". $Tdate_format ."' and b.damt-b.payment>0 THEN (b.interest+b.FEEINT)-b.V_PAYMENT ELSE 0 END 
                                    //                 ) AS sumKangInt
                                    
                                    //                 FROM      dbo.PatchPSL_Contracts AS a  
                                    //                         left join dbo.PatchPSL_paydueLoan AS b ON a.CONTNO = b.contno
                                    //                         LEFT JOIN PatchPSL_CHQTran AS c ON a.CONTNO = c.contno AND c.PAYFOR = '007' and c.FLAG <>'C'
                                    //                 WHERE (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 3) 
                                                        
                                    //                 GROUP BY a.CONTNO)
                                    //     SELECT a.locat, a.contno, a.CONTTYP, a.CODLOAN, a.Name_Cus, a.sdate, a.fdate, a.ldate, a.t_nopay, a.tcshprc, a.NETPROFIT, a.tot_upay, a.totprc, a.totprc - a.SMPAY AS Arbl,a.capitalbl , a.userzone, a.dataTable, a.DTSTOPV,
                                    //             b.payintbefore, b.inteffmonth, b.intbalance,b.payintbeforeFee, b.inteffmonthFee, b.intbalanceFee ,b.sumDamt,b.sumIntdue ,ISNULL(c.sumPayamt,0) as sumPayamt  ,ISNULL(c.sumPayInt,0) as sumPayInt ,ISNULL(c.sumKangInt,0) as sumKangInt  ,a.EXP_AMT
                                    //         FROM     dbo.VWBC_PatchContracts AS a 
                                    //             LEFT OUTER JOIN  dataDueAcc AS b ON b.CONTNO = a.contno
                                    //             LEFT OUTER JOIN  duePay AS c ON c.CONTNO = a.contno
                                    //         WHERE  (a.capitalbl > 0 ) 
                                    //         AND (a.UserZone = ". $u_zone .") AND (a.CONTTYP = 3) and a.dataTable = 'PSL'
                                    // ");
                                break;
                            }
                        }
                    } else {
                        switch ($typeProfit) {
                            case 'profitFollowDate':
                                $dataProfitfollow = DB::select("select * from utf_HPRepDueEffr(?,?,?,?,?)",[$branchNew,$Contno_r,$Fdate_format,$Tdate_format,$u_zone]);
                                // $dataProfitfollow = DB::select("
                                //     WITH dataDueAcc AS (
                                //         SELECT a.CONTNO, 
                                //         SUM(CASE WHEN a.DTSTOPV IS NULL THEN 
                                //             CASE WHEN format(CAST(b.ddate AS date), 'yyyy-MM')< '". $month ."' THEN b.interest ELSE 0 END 
                                //             ELSE 
                                //             CASE WHEN b.ddate < a.DTSTOPV THEN b.interest ELSE 0 END END) AS payintbefore, 
                                        
                                //         SUM(CASE WHEN a.DTSTOPV IS NULL THEN 
                                //                     CASE WHEN b.ddate between '". $Fdate_format ."' and '". $Tdate_format ."' AND c.TMBILDT is null THEN b.interest ELSE 
                                //                     CASE WHEN c.TMBILDT between '". $Fdate_format ."' and '". $Tdate_format ."'  AND b.ddate >= '". $Fdate_format ."' then b.interest else 0   end
                                //                     END 
                                //                 WHEN a.DTSTOPV IS NOT NULL  THEN 
                                //                     CASE WHEN b.ddate < a.DTSTOPV THEN 0 end else
                                //                     case WHEN  c.TMBILDT between '". $Fdate_format ."' and '". $Tdate_format ."' AND b.ddate >= a.DTSTOPV THEN b.interest end END) AS inteffmonth, 
                                        
                                //         SUM(CASE WHEN a.DTSTOPV IS NULL  AND c.TMBILDT is null  THEN 
                                //             CASE WHEN format(CAST(b.ddate AS date), 'yyyy-MM-dd') > '". $Tdate_format ."' THEN b.interest ELSE 0 END 
                                //                 WHEN a.DTSTOPV IS NOT NULL AND a.TOTPRC - a.SMPAY > 0 THEN 
                                //             CASE WHEN b.ddate >= a.DTSTOPV THEN b.interest ELSE 0 END WHEN a.TOTPRC - a.SMPAY = 0 THEN 0 END) AS intbalance,
                                        
                                //             SUM(CASE WHEN a.DTSTOPV IS NULL  AND c.TMBILDT is null  THEN 
                                //             CASE WHEN format(CAST(b.ddate AS date), 'yyyy-MM') > '". $Tdate_format ."'  THEN b.damt_v-b.payment_v ELSE 0 END 
                                //                 WHEN a.DTSTOPV IS NOT NULL AND a.TOTPRC - a.SMPAY > 0 THEN 
                                //                 CASE WHEN b.ddate >= a.DTSTOPV THEN b.damt_v ELSE 0 END
                                //                         WHEN a.TOTPRC - a.SMPAY = 0 THEN 0 END) AS vatbalance,
                                //             SUM(  
                                //                 CASE WHEN format(CAST(b.date1 AS date), 'yyyy-MM')= format(CAST(c.TMBILDT AS date), 'yyyy-MM') THEN b.payment_v ELSE 0 END 
                                //             ) AS vatClose,
                                //             SUM(  
                                //                 CASE WHEN format(CAST(b.date1 AS date), 'yyyy-MM')=format(CAST(c.TMBILDT AS date), 'yyyy-MM')  THEN b.payment_n ELSE 0 END 
                                //             ) AS dueClose
                                        
                                //             FROM      dbo.PatchHP_Contracts AS a LEFT OUTER JOIN
                                //                             dbo.PatchHP_paydue  AS b ON a.CONTNO = b.contno
                                //                             LEFT JOIN PatchHP_CHQTran AS c ON a.CONTNO = c.contno AND c.PAYFOR = '007' and c.FLAG <>'C'
                                //             WHERE   (a.TOTPRC - a.SMPAY > 0 OR (format(CAST(a.LPAYD AS date), 'yyyy-MM-dd')  between '". $Fdate_format ."' and '". $Tdate_format ."') ) AND (a.UserZone = ". $u_zone .") 
                                                            
                                //             GROUP BY a.CONTNO
                                //     ),
                                //     duePay as (select a.CONTNO,
                                //         SUM(CASE WHEN a.DTSTOPV IS NULL THEN 
                                //             CASE WHEN format(CAST(d.ddate AS date), 'yyyy-MM-dd')<= c.TMBILDT THEN d.interest ELSE 0 END 
                                //             ELSE 
                                //             CASE WHEN d.ddate < a.DTSTOPV THEN d.interest ELSE 0 END END) AS dueIntAll
                                            
                                //             FROM      dbo.PatchHP_Contracts AS a  
                                //                             left join dbo.PatchHP_paydue  AS d ON a.CONTNO = d.contno
                                //                             LEFT JOIN PatchHP_CHQTran AS c ON a.CONTNO = c.contno  
                                //             WHERE    (format(CAST(c.TMBILDT AS date), 'yyyy-MM-dd')  between '". $Fdate_format ."' and '". $Tdate_format ."') AND c.PAYFOR = '007' and c.FLAG <>'C'   AND (a.UserZone = ". $u_zone .")  
                                                
                                //             GROUP BY a.CONTNO
                                //     ),
                                //     DateDue as (select a.CONTNO,d.ddate,
                                //     case when a.DTSTOPV IS NULL THEN  d.damt_n else 0 end as damt_n,
                                //     case when a.DTSTOPV IS NULL THEN   d.damt_v else 0 end as damt_v
                                //         FROM   dbo.PatchHP_Contracts AS a  
                                //                 left join dbo.PatchHP_paydue  AS d ON a.CONTNO = d.contno								
                                //         WHERE  (a.UserZone = ". $u_zone .")   and format(CAST(d.ddate AS date), 'yyyy-MM-dd') between '". $Fdate_format ."' and '". $Tdate_format ."'                     
                                //         --GROUP BY a.CONTNO,d.ddate,d.damt_n,d.damt_v	
                                //     )

                                //     SELECT a.locat, a.contno, a.CONTTYP, a.CODLOAN, a.Name_Cus, a.sdate, a.fdate, a.ldate, a.t_nopay, a.tcshprc, a.NETPROFIT, a.tot_upay, a.totprc, a.totprc - a.SMPAY AS Arbl, a.userzone, a.dataTable, a.DTSTOPV,
                                //         b.payintbefore, b.inteffmonth, b.intbalance,b.vatbalance ,ISNULL(c.dueIntAll,0),d.ddate, 
                                //         ISNULL(case when b.vatClose >0 then b.vatClose else d.damt_v end,0) as vatDue,
                                //         ISNULL(case when b.dueClose >0 then b.dueClose else d.damt_n end,0) as DueCs
                                        
                                //         ,e.DISCT
                                //         FROM     dbo.VWBC_PatchContracts AS a 
                                //             LEFT OUTER JOIN  dataDueAcc AS b ON b.CONTNO = a.contno
                                //             LEFT OUTER JOIN  duePay AS c ON c.CONTNO = a.contno
                                //             LEFT OUTER JOIN  DateDue AS d ON d.CONTNO = a.contno
                                //             LEFT JOIN PatchHP_CHQTran AS e ON a.CONTNO = e.contno  and e.FLAG <>'C' and PAYFOR ='007'
                                //         WHERE  (a.TOTPRC - a.SMPAY > 0   OR (format(CAST(a.LPAYD AS date), 'yyyy-MM-dd')  between '". $Fdate_format ."' and '". $Tdate_format ."')  ) 
                                //         AND (a.UserZone = ". $u_zone .")  and a.dataTable = 'HP' and a.locat LIKE '".$branchNew."'
                                // ");
                            break;
                            case 'profit':
                                $dataProfit = DB::select("
                                    WITH dataDueAcc AS (
                                        SELECT a.CONTNO, 
                                        SUM( 
                                            CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM-dd')<='". $Tdate_format ."' THEN b.damt_n ELSE 0 END 
                                        ) AS sumDamt, 
                                        SUM( 
                                            CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM-dd')<= '". $Tdate_format ."' THEN b.interest ELSE 0 END 
                                        ) AS sumIntdue , 
                                        SUM(CASE WHEN a.DTSTOPV IS NULL THEN 
                                            CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM')< '". $month ."' THEN b.interest ELSE 0 END 
                                            ELSE 
                                            CASE WHEN b.DDATE < a.DTSTOPV THEN b.interest ELSE 0 END END) AS payintbefore, 
                                        
                                        SUM(CASE WHEN a.DTSTOPV IS NULL THEN 
                                                    CASE WHEN b.DDATE between '". $Fdate_format ."' and '". $Tdate_format ."'   THEN b.interest ELSE 
                                                    0    
                                                    END 
                                                WHEN a.DTSTOPV IS NOT NULL  THEN 
                                                    CASE WHEN b.DDATE < a.DTSTOPV THEN 0 end else
                                                    case WHEN  b.DDATE >= a.DTSTOPV THEN b.interest end END) AS inteffmonth, 
                                        
                                        SUM(CASE WHEN a.DTSTOPV IS NULL    THEN 
                                            CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM-dd') > '". $Tdate_format ."' THEN b.interest ELSE 0 END 
                                                WHEN a.DTSTOPV IS NOT NULL AND a.TOTPRC - a.SMPAY > 0 THEN 
                                            CASE WHEN b.DDATE >= a.DTSTOPV THEN b.interest ELSE 0 END end  ) AS intbalance, 
                                        
                                        SUM(CASE WHEN a.DTSTOPV IS NULL    THEN 
                                            CASE WHEN format(CAST(b.DDATE AS date), 'yyyy-MM-dd') > '". $Tdate_format ."' THEN b.damt_v-b.payment_v ELSE 0 END 
                                                WHEN a.DTSTOPV IS NOT NULL AND a.TOTPRC - a.SMPAY > 0 THEN 
                                            CASE WHEN b.DDATE >= a.DTSTOPV THEN b.damt_v-b.payment_v ELSE 0 END end  ) AS Vatbalance
                                        
                                            FROM      dbo.PatchHP_Contracts AS a LEFT OUTER JOIN
                                                            dbo.PatchHP_paydue  AS b ON a.CONTNO = b.contno
                                                            
                                            WHERE   (a.TOTPRC - a.SMPAY > 0  ) AND (a.UserZone = ". $u_zone .") 
                                                            
                                            GROUP BY a.CONTNO
                                        ),
                                    duePay as(
                                        select a.CONTNO,
                                        SUM( 
                                            CASE WHEN  b.payment>0 THEN round((b.payment_n-((b.payment_n/b.damt_n)*b.capital)),2) ELSE 0 END 
                                            ) AS sumPayInt,
                                        SUM( 
                                            CASE WHEN  b.payment>0 THEN b.payment_n ELSE 0 END 
                                            ) AS sumPayamt,
                                            SUM( 
                                            CASE WHEN  format(CAST(b.ddate AS date), 'yyyy-MM-dd')<='". $Tdate_format ."' and b.damt-b.payment>0 THEN 
                                            b.interest-round((b.payment_n-((b.payment_n/b.damt_n)*b.capital)),2)
                                            ELSE 0 END 
                                            ) AS sumKangInt,
                                            SUM( 
                                            CASE WHEN  format(CAST(b.ddate AS date), 'yyyy-MM-dd')<='". $Tdate_format ."' and b.damt-b.payment>0 THEN 
                                            b.damt_n-b.payment_n
                                            ELSE 0 END 
                                            ) AS sumKangPay

                                            FROM      dbo.PatchHP_Contracts AS a  
                                                            left join dbo.PatchHP_paydue  AS b ON a.CONTNO = b.contno								
                                            WHERE (a.UserZone = ". $u_zone .")  
                                                
                                            GROUP BY a.CONTNO
                                    )
                                    SELECT a.locat, a.contno, a.CONTTYP, a.CODLOAN, a.Name_Cus, a.sdate, a.fdate, a.ldate, a.t_nopay, a.tcshprc, a.NETPROFIT, a.tot_upay, a.totprc, a.totprc - a.SMPAY AS Arbl,a.capitalbl , a.userzone, a.dataTable, a.DTSTOPV,
                                        b.payintbefore, b.inteffmonth, b.intbalance ,b.sumDamt,b.sumIntdue ,ISNULL(c.sumPayamt,0) as sumPayamt  ,ISNULL(c.sumPayInt,0) as sumPayInt ,ISNULL(c.sumKangInt,0) as sumKangInt  ,a.EXP_AMT
                                        ,ISNULL(c.sumKangPay,0) as sumKangPay,ISNULL(b.Vatbalance,0) as Vatbalance
                                        FROM     dbo.VWBC_PatchContracts AS a 
                                            LEFT OUTER JOIN  dataDueAcc AS b ON b.CONTNO = a.contno
                                            LEFT OUTER JOIN  duePay AS c ON c.CONTNO = a.contno
                                        WHERE  (a.TOTPRC - a.SMPAY > 0 ) 
                                        AND (a.UserZone = ". $u_zone .")   and a.dataTable = 'HP' and a.locat LIKE '". $branchNew ."'
                                ");
                            break;
                        }
                    }
                
                    if ($typeReport == 'PDF') {
                        $countPage = 0;
                        Storage::delete('public/pdf/profit_zone-'. $u_zone .'.pdf');
                        $CalResponse = empty($dataProfitfollow) ? $dataProfit : $dataProfitfollow;
                        //การกำหนดกลุ่มข้อมูล
                        $numGroups = count($CalResponse) > 750 ? 8 : 1;
                        //เอา data ทีได้จาก query มาหารกับกลุ่ม
                        $groupSize = ceil(count($CalResponse) / $numGroups);
                        $file_name = array();

                        // loop เพื่อสร้าง pdf ตามกลุ่ม
                        for ($i = 0; $i < count($CalResponse) ; $i++) {
                            $ArrayCount = $i;
                            // ถ้าจำนวนข้อมูลมากกว่า Size ของกลุ่ม ให้สร้างกลุ่มข้อมูลใหม่
                            if ($i % $groupSize == 0) {
                                unset($dataCut);
                            }

                            if($countPage == ($numGroups - 1)) {
                                $cal = (count($CalResponse) - $i);
                                dump($cal, $i, $CalResponse);
                            }

                            $dataCut[$i] = $CalResponse[$ArrayCount];

                            // ถ้าจำนวนข้อมูลเท่ากับ Size ของกลุ่ม ให้สร้าง pdf ของแต่ละกลุ่ม
                            if(($i + 1) % $groupSize == 0) {
                                $length = 16;
                                $bytes = random_bytes($length);
                                $Token = bin2hex($bytes);

                                $options = new Options();
                                $options->set('isHtml5ParserEnabled', true);
                                $options->set('isPhpEnabled', true);
                                $options->set('isRemoteEnabled', true);
                                $options->set('defaultFont',  asset('fonts/TF Pimpakarn.ttf') );
            
                                $dompdf =  new  Dompdf($options);
            
                                if($typeProfit == 'profitFollowDate') {
                                    $view = View::make('backend.content-report.PDF.Form-ProfitFollowDate', compact('Fdate','Tdate', 'datePrint', 'dataCut', 'conttype', 'tableLoan', 'ArrayCount', 'countPage'));
                                } else {
                                    $view = View::make('backend.content-report.PDF.Form-Profit', compact('Fdate','Tdate', 'datePrint', 'dataCut', 'conttype', 'ArrayCount', 'countPage'));
                                }
            
                                $html = $view->render();
                                $dompdf->set_paper('A4', 'landscape');
                                $dompdf->loadHTML($html);
                                $dompdf->render();
                                $output = $dompdf->output();
                                // เอาไฟล์ที่ได้มาเก็บไว้ใน path ที่ต้องการ
                                file_put_contents("storage/pdf/"."profit-arr-".$i."-".$Token.".pdf", $output);
                                //  ตัวแปรใช้เก็บ path ของไฟล์
                                $file_name[$i] = "profit-arr-".$i."-".$Token.".pdf";
                                // ล้าง memory ของ dompdf
                                $dompdf = null;
                                unset($dompdf);
                            }
                        }

                        // init ตัว merge package เพื่อรวม pdf
                        $merger = new Merger();

                        // เอาไฟล์ที่อยู่ใน array มา merge เข้าด้วยกัน
                        foreach ($file_name as $pdf) {
                            $pdfPath = storage_path('app/public/pdf/'. $pdf);
                            $merger->addFile($pdfPath);
                        }
                        // รวม pdf เข้าด้วยกัน
                        $mergedPdf = $merger->merge();
                        $outputPath = storage_path('app/public/pdf/profit_zone-'. $u_zone .'.pdf');
                        file_put_contents($outputPath, $mergedPdf);

                        // ลบไฟล์ที่อยู่ใน array ทิ้ง
                        foreach ($file_name as $file) {
                            Storage::delete('public/pdf/'. $file);
                        }

                        $outputFilePath = 'pdf/profit_zone-'. $u_zone .'.pdf';

                        // return func stream pdf กลับไป 
                        if (Storage::disk('public')->exists($outputFilePath)) {
                            return response()->stream(function () use ($outputFilePath) {
                                $stream = Storage::disk('public')->readStream($outputFilePath);
                                fpassthru($stream);
                            }, 200, [
                                'Content-Type' => 'application/pdf',
                                'Content-Disposition' => 'inline; filename="profit.pdf"',
                            ]);
                        } else {
                            abort(404, 'File not found.');
                        }
                    } else {
                        if($typeProfit == 'profitFollowDate') { 
                            return view('backend.content-report.EXCEL.ProfitFollowDate',  compact('Fdate','Tdate', 'dataProfitfollow', 'conttype', 'tableLoan', 'branchsAll'));
                        } else {
                            return view('backend.content-report.EXCEL.profit-report',  compact('Fdate','Tdate', 'dataProfit', 'conttype', 'tableLoan', 'branchsAll'));
                        }
                    }
                } catch (\Exception $e) {
                    return abort(404, 'File not found.');
                }
            } else if($request->report == 'TaxSlip') {
                // dd($Fdate_format, $Tdate_format);
                $response = DB::table('View_TxtTran')->whereRaw("TAXDT BETWEEN '". $Fdate_format ."' AND '". $Tdate_format ."' AND UserZone = '". $u_zone ."'")->get();

                if(count($response) !== 0 ) {
                    $options = new Options();
                    $options->set('isHtml5ParserEnabled', true);
                    $options->set('isPhpEnabled', true);
                    $options->set('isRemoteEnabled', true);
                    $options->set('defaultFont',  asset('fonts/TF Pimpakarn.ttf') );

                    $dompdf =  new  Dompdf($options);

                    $view = View::make('backend.content-report.PDF.Form-Taxslip', compact('response'));

                    $html = $view->render();
                    // $dompdf->set_paper('A4', 'landscape');
                    $dompdf->set_paper('A4', 'portrait');
                    $dompdf->loadHTML( $html);
                    $dompdf->render();
                    $dompdf->stream('Tax Slip.pdf',array('Attachment'=>0));
                } else {
                    return view('components.content-alert.export-err');
                }
            } else if($request->report == 'Store') { // ลูกหนี้งานตาม + โทร 
                $data_split = explode('-', $Fdate);
                $Fdate_format = "{$data_split[2]}-{$data_split[1]}";

                $response = DB::table('View_PivotSpartDue')
                ->whereRaw("FORMAT(LAST_ASSIGNDT, 'yyyy-MM') = '". $Fdate_format ."' AND UserZone = '". $u_zone ."'")
                ->get();

                $res_all = DB::table('VWDEBT_RPSPASTDUEALL')
                ->whereRaw("FORMAT(LAST_ASSIGNDT, 'yyyy-MM') = '". $Fdate_format ."' AND UserZone = '". $u_zone ."'")
                ->get();

                return view('backend.content-report.EXCEL.store-report', compact('response', 'Fdate', 'Tdate', 'res_all'));
            } else if($request->report == 'ArReport'){
                $RequestZone = $request->zone!=NULL?$request->zone:$u_zone;
                    $data =  $data = DB::table("VWBC_PatchContracts")
                    ->leftJoin('TB_Branchs', function ($join) {
                        $join->on('VWBC_PatchContracts.locat', '=', 'TB_Branchs.id');
                    })
                    ->selectRaw("TB_Branchs.Name_Branch,VWBC_PatchContracts.contno,VWBC_PatchContracts.Name_Cus,VWBC_PatchContracts.sdate,VWBC_PatchContracts.fdate,
                    VWBC_PatchContracts.ldate,VWBC_PatchContracts.tcshprc,VWBC_PatchContracts.NETPROFIT,VWBC_PatchContracts.totprc,VWBC_PatchContracts.t_nopay,VWBC_PatchContracts.SMPAY,
                                    VWBC_PatchContracts.EXP_AMT,VWBC_PatchContracts.totprc-VWBC_PatchContracts.SMPAY as arbl , VWBC_PatchContracts.userzone,VWBC_PatchContracts.dataTable")
                    ->where("VWBC_PatchContracts.dataTable",$tableLoan)
                    ->where('VWBC_PatchContracts.userzone',$RequestZone)
                    ->whereRaw('totprc-SMPAY > 0' )
                    ->get();
                    return View('backend.content-report.EXCEL.Accounts.arReport', compact('data','Fdate','Tdate','tableLoan'));
            }

            //[dbo].[VWDEBT_PatchContracts]
        }
    }

    private function DowloadPDF() {

    }

    public function getRole(Request $request) {
        try {
            $role = ['financial'];
            $response = User::
            selectRaw("id, name, zone")
            ->where('zone', $request->data['zone'])
            ->whereHas('roles', function($q) use ($role) {
                $q->whereIn('name', $role);
            })->get();

            return response()->json([
                'message' => 'query success',
                'body' => $response,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        } 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
