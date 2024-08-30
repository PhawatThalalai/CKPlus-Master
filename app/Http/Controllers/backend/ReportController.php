<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\User;
use Illuminate\Http\Request;

use App\Models\TB_PactContracts\Pact_Indentures_Assets;
use App\Models\TB_DataCus\Data_CusAssets;

use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_Contracts;
use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_CHQMas;

use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_Contracts;
use App\Models\TB_PatchContracts\TB_Payments\PatchHP\PatchHP_CHQMas;

use App\Models\TB_temp\TMP_ACCTCLOSE\TMP_ACCTCLOSEHP;
use App\Models\TB_temp\TMP_ACCTCLOSE\TMP_ACCTCLOSEPSL;
use App\Models\TB_Letter\Data_PRINTLET;

use App\Models\TB_Constants\TB_Frontend\TB_TypeLoan;
use App\Models\TB_Constants\TB_Frontend\TB_Company;
use DB;
use PDF;
use Barryvdh\DomPDF\Facade\Pdf as domPDF;
use Picqer;
use QrCode;

// use PDF;

// use Dompdf\Dompdf;
use Dompdf\Options;

use App\Models\TB_PactContracts\Pact_Contracts;

class ReportController extends Controller
{
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

            // $pdf = domPDF::loadHTML($html);
            // $pdf->setPaper('F4', 'P');
            // return @$pdf->stream();
        }
    }

    public function create(Request $request)
    {   //select contract
        // dd($request->codloan);
        if ($request->page == 'rp-terminate') {
            if ($request->codloan == 2) {
                $data = PatchHP_Contracts::where('DataPact_id', $request->pact_id)->first();
            } else {
                $data = PatchPSL_Contracts::where('DataPact_id', $request->pact_id)->first();
            }
            $codloan = $request->codloan;
            $pact_id = $request->pact_id;
            return view('backend.content-temp.section-terminate.modal', compact('data', 'codloan', 'pact_id'));
        } elseif ($request->page == 'reportBOT') {
            $Company_Id = '0815559000291';
            $dateMonth = '2024-01-31';
            return view('backend.content-report.EXCEL.botReport', compact('Company_Id', 'dateMonth'));
        } else if ($request->page == 'exportLetter') {
            try {
                $dataResToArr = [];

                $data = $request->data;

                dd($data);
                
                foreach ($data as $key => $value) {
                    if (is_string($key)) {
                        unset($data[$key]);
                    }
                }

                foreach ($data as $key => $value) {
                    $response = DB::table('Data_PRINTLET')
                        ->selectRaw("Data_PRINTLET.id, USERID, LOCAT, CONTNO, Prefix, Firstname_Cus, Surname_Cus, PRINTDT, Phone_cus, Name_Cus, EMSNO, EMSsDT")
                        ->leftJoin("Data_Customers", "Data_PRINTLET.USERID", "=", "Data_Customers.id")
                        ->whereRaw("Data_PRINTLET.id = '" . $key . "' AND Data_PRINTLET.userzone = '" . auth()->user()->zone . "' AND EMSNO IS NOT NULL")->get()[0];

                    array_push($dataResToArr, $response);
                }

                $view = \View::make('backend.content-report.PDF.Letter.Form-letter', compact('dataResToArr'));
                $html = $view->render();
                $pdf = new PDF();
                $pdf::SetTitle('SaveLetter');
                $pdf::AddPage('P', 'A4');
                $pdf::SetMargins(5, 5, 5, 0);
                $pdf::SetFont('thsarabun', '', 15, '', true);
                $pdf::SetAutoPageBreak(TRUE, 20);
                $pdf::WriteHTML($html, true, false, true, false, '');
                $pdf::Output('save-letter.pdf');

                return response()->json(['message' => 'Export save letter'], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage()], 500);
            }
        }
    }

    public function show(Request $request, $id)
    {
        if ($request->page == 'rp-paydue') {
            /* get session last */
            $flag_pt = session()->pull('flag_pt');
            $contract = session()->get('contract');
            $CHQMas = session()->get('data_CHQMas');

            if (isset($flag_pt) || $request->flag_pt == true) {
                if ($request->codloan == 1) {
                    $CHQMas = PatchPSL_CHQMas::where('id', $id)
                        ->with([
                            'CHMasToCHTranOn' => function ($query) {
                                $query->select('id', 'ChqMas_id', 'PAYFOR', 'PAYAMT', 'DISCT', 'PAYINT', 'DSCINT', 'NETPAY', 'PAYFL', 'DSCPAYFL', 'PAYAMT_N', 'PAYAMT_V', 'F_PAR', 'F_PAY', 'L_PAR', 'L_PAY', 'NOPAY');
                            }
                        ])
                        ->with([
                            'CHMasToCHTranMn' => function ($query) {
                                $query->select('id', 'ChqMas_id', 'PAYFOR', 'PAYAMT', 'DISCT', 'PAYINT', 'DSCINT', 'NETPAY', 'PAYFL', 'DSCPAYFL', 'PAYAMT_N', 'PAYAMT_V', 'F_PAR', 'F_PAY', 'L_PAR', 'L_PAY', 'NOPAY');
                            }
                        ])
                        ->first();

                    $contcus = DB::table('Psl_ConCus')
                        ->where('id', $CHQMas->PatchCon_id)
                        ->where('Company_Zone', $CHQMas->CHQMasContract->UserZone)
                        ->first();

                } else {
                    $CHQMas = PatchHP_CHQMas::where('id', $id)
                        ->with([
                            'CHMasToCHTranOn' => function ($query) {
                                $query->select('id', 'ChqMas_id', 'PAYFOR', 'PAYAMT', 'DISCT', 'PAYINT', 'DSCINT', 'NETPAY', 'PAYFL', 'DSCPAYFL', 'PAYAMT_N', 'PAYAMT_V', 'F_PAR', 'F_PAY', 'L_PAR', 'L_PAY', 'NOPAY');
                            }
                        ])
                        ->with([
                            'CHMasToCHTranMn' => function ($query) {
                                $query->select('id', 'ChqMas_id', 'PAYFOR', 'PAYAMT', 'DISCT', 'PAYINT', 'DSCINT', 'NETPAY', 'PAYFL', 'DSCPAYFL', 'PAYAMT_N', 'PAYAMT_V', 'F_PAR', 'F_PAY', 'L_PAR', 'L_PAY', 'NOPAY');
                            }
                        ])
                        ->first();

                    $contcus = DB::table('Hp_ConCus')
                        ->where('id', $CHQMas->PatchCon_id)
                        ->where('Company_Zone', $CHQMas->CHQMasContract->UserZone)
                        ->first();
                }

                $contasset = Pact_Indentures_Assets::where('PactCon_id', $contcus->DataPact_id)->first();
                $_namefile = $this->generateQr_BarCode($contcus->CONTNO, $contcus->TYPECON, $contcus->Company_Id, $contcus->Company_Branch, auth()->user()->zone);

                if ($CHQMas->TYPEPAY == 'Payment') {
                    $CHQTran = $CHQMas->CHMasToCHTranOn;
                    if ($request->typeRp == 'A4') {
                        $sizePage = 'portrait';
                        $view = \View::make('backend.content-report.section-payments.due-payment', compact('contcus', 'contasset', 'CHQMas', 'CHQTran', '_namefile'));
                    } else {
                        $sizePage = 'landscape';
                        $view = \View::make('backend.content-report.section-payments.due-payment-A5', compact('contcus', 'contasset', 'CHQMas', 'CHQTran', '_namefile'));
                    }
                } else {
                    $sizePage = 'portrait';
                    $CHQTran = $CHQMas->CHMasToCHTranMn;
                    $view = \View::make('backend.content-report.section-payments.due-paymentOther', compact('contcus', 'contasset', 'CHQMas', 'CHQTran', '_namefile'));
                }
                $html = $view->render();
                $pdf = domPDF::loadHTML($html);
                $pdf->setPaper($request->typeRp, $sizePage);

                if ($request->flag_pt == 'true') { //watermark
                    $canvas = $pdf->getCanvas();

                    // Get height and width of page
                    $w = $canvas->get_width();
                    $h = $canvas->get_height();

                    // Specify watermark image
                    $imageURL = public_path() . '/assets/images/copy.png';
                    $imgWidth = 333;
                    $imgHeight = 424;

                    // Set image opacity
                    $canvas->set_opacity(.5);

                    // Specify horizontal and vertical position
                    $x = (($w - $imgWidth) / 2);
                    $y = (($h - $imgHeight) / 3);

                    // Add an image to the pdf

                    /**
                     * Add an image to the pdf.
                     *
                     * The image is placed at the specified x and y coordinates with the
                     * given width and height.
                     *
                     * @param string $img_url the path to the image
                     * @param float $x x position
                     * @param float $y y position
                     * @param int $w width (in pixels)
                     * @param int $h height (in pixels)
                     * @param string $resolution The resolution of the image
                     */

                    //$canvas->image($imageURL, $x, $y, $imgWidth, $imgHeight,$resolution = "normal");
                    $canvas->image($imageURL, $x, $y, $imgWidth, $imgHeight, $resolution = "normal");
                }
                return $pdf->stream('payments');
            } else {
                dd('session timeout');
            }
        } elseif ($request->page == 'rp-terminate') { //หนังสือยืนยันบอกเลิกสัญญา
            if ($request->codloan == 2) {
                $data = PatchHP_Contracts::where('DataPact_id', $id)->first();

                $dataComp = TB_Company::where('Company_Zone', $data->UserZone)
                    ->where('id', $data->Id_Com)
                    ->first();
            } else {
                $data = PatchPSL_Contracts::where('DataPact_id', $id)->first();
                $dataComp = TB_Company::where('Company_Zone', $data->UserZone)
                    ->where('id', $data->Id_Com)
                    ->first();
            }
            $codloan = $request->codloan;
            $datePrint = $request->datePrint;
            $dateTerminate = convertDateHumanToPHP($request->dateTerminate);
            $Note = $request->Note;
            $staff = $request->staff;
            $view = \View::make('backend.content-report.section-terminates.viewpdf', compact('codloan', 'data', 'dataComp', 'datePrint', 'dateTerminate', 'Note', 'staff'));
            $html = $view->render();
            $pdf = new PDF();
            $pdf::SetTitle('หนังสือยืนยันบอกเลิกสัญญา');
            $pdf::AddPage('P', 'A4');
            $pdf::SetMargins(5, 5, 5, 0);
            $pdf::SetFontSpacing(0);
            $pdf::SetFont('thsarabun', '', 15, '', true);
            $pdf::SetAutoPageBreak(TRUE, 20);
            $pdf::WriteHTML($html, true, false, true, false, '');
            $pdf::Output('ReportTerminate.pdf');
        } elseif ($request->page == 'rp-transferPay') {
            /* get session last */
            // $reportArr = session()->get('reportArr');
            $reportArr = explode(',', $request->reportArr);
            // dd($reportArr);

            if (true) {
                if ($request->codloan == 1) {
                    $CHQMas = PatchPSL_CHQMas::whereIn('id', $reportArr)
                        ->with([
                            'CHMasToCHTranOn' => function ($query) {
                                $query->select('id', 'ChqMas_id', 'PAYFOR', 'PAYAMT', 'DISCT', 'PAYINT', 'DSCINT', 'NETPAY', 'PAYFL', 'DSCPAYFL', 'F_PAR', 'F_PAY', 'L_PAR', 'L_PAY', 'NOPAY');
                            }
                        ])
                        ->with([
                            'CHMasToCHTranMn' => function ($query) {
                                $query->select('id', 'ChqMas_id', 'PAYFOR', 'PAYAMT', 'DISCT', 'PAYINT', 'DSCINT', 'NETPAY', 'PAYFL', 'DSCPAYFL', 'F_PAR', 'F_PAY', 'L_PAR', 'L_PAY', 'NOPAY');
                            }
                        ])
                        ->get();

                    $contcus = DB::table('Psl_ConCus')
                        ->where('id', $CHQMas->PatchCon_id)
                        ->where('Company_Zone', $CHQMas->CHQMasContract->UserZone)
                        ->first();

                } else {
                    $CHQMas = PatchHP_CHQMas::whereIn('id', $reportArr)
                        ->with([
                            'CHMasToCHTranOn' => function ($query) {
                                $query->select('id', 'ChqMas_id', 'PAYFOR', 'PAYAMT', 'DISCT', 'PAYINT', 'DSCINT', 'NETPAY', 'PAYFL', 'DSCPAYFL', 'F_PAR', 'F_PAY', 'L_PAR', 'L_PAY', 'NOPAY');
                            }
                        ])
                        ->with([
                            'CHMasToCHTranMn' => function ($query) {
                                $query->select('id', 'ChqMas_id', 'PAYFOR', 'PAYAMT', 'DISCT', 'PAYINT', 'DSCINT', 'NETPAY', 'PAYFL', 'DSCPAYFL', 'F_PAR', 'F_PAY', 'L_PAR', 'L_PAY', 'NOPAY');
                            }
                        ])
                        ->get();
                    $contcus = DB::table('Hp_ConCus')
                        ->where('id', $CHQMas[0]->PatchCon_id)
                        ->where('Company_Zone', $CHQMas[0]->CHQMasContract->UserZone)
                        ->first();
                }
                $CHQMasLoop = $CHQMas;
                $contasset = Pact_Indentures_Assets::where('PactCon_id', $contcus->DataPact_id)->first();
                $_namefile = $this->generateQr_BarCode($contcus->CONTNO, $contcus->TYPECON, $contcus->Company_Id, $contcus->Company_Branch, auth()->user()->zone);
                $html = '';
                foreach ($CHQMasLoop as $CHQMas) {
                    if ($CHQMas->TYPEPAY == 'Payment') {
                        $CHQTran = $CHQMas->CHMasToCHTranOn;
                        // dd($CHQTran);

                        $view = \View::make('backend.content-report.section-payments.due-payment', compact('contcus', 'contasset', 'CHQMas', 'CHQTran', '_namefile'));
                        $html .= $view->render();
                    } else {
                        $CHQTran = $CHQMas->CHMasToCHTranMn;
                        $view = \View::make('backend.content-report.section-payments.due-paymentOther', compact('contcus', 'contasset', 'CHQMas', 'CHQTran', '_namefile'));
                        $html .= $view->render();
                    }
                }
                $pdf = domPDF::loadHTML($html);

                $pdf->setPaper('A4', 'P');
                // if ($request->flag_pt == 'true') { //watermark
                //     $canvas = $pdf->getCanvas();

                //     // Get height and width of page
                //     $w = $canvas->get_width();
                //     $h = $canvas->get_height();

                //     // Specify watermark image
                //     $imageURL = public_path() . '/assets/images/copy.png';
                //     $imgWidth = 333;
                //     $imgHeight = 424;

                //     // Set image opacity
                //     $canvas->set_opacity(.5);

                //     // Specify horizontal and vertical position
                //     $x = (($w - $imgWidth) / 2);
                //     $y = (($h - $imgHeight) / 3);
                //     $canvas->image($imageURL, $x, $y, $imgWidth, $imgHeight, $resolution = "normal");
                // }
                return $pdf->stream('payments');
            } else {
                dd('session timeout');
            }

        } elseif ($request->page == 'close-ac') {
            /*
            if($request->CODLOAN == 1) { // เงินกู้

            } elseif ($request->CODLOAN == 2) { // เช่าซื้อ
                $data = PatchHP_Contracts::where('DataPact_id',$id)->first();
                $dataComp = TB_Company::where('Company_Zone',auth()->user()->zone)
                            ->where('Company_Type',2)
                            ->first();
            }
            else{
                $data = PatchPSL_Contracts::where('DataPact_id',$id)->first();
                $dataComp = TB_Company::where('Company_Zone',auth()->user()->zone)
                            ->where('Company_Type',1)
                            ->first();
            }
            */

            $itemid = $request->itemid;

            if ($request->type == 'approve') {
                // close-AC-approve
                $codloan = $request->CODLOAN;

                if ($codloan == 1) { // เงินกู้
                    $data = TMP_ACCTCLOSEPSL::where('id', $itemid)->first();
                } else if ($codloan == 2) {  // เช่าซื้อ
                    $data = TMP_ACCTCLOSEHP::where('id', $itemid)->first();
                }
                $codloan = $data->AccCloseToContract->CODLOAN;
                $company = TB_Company::getCompanyByZoneAndCodeLoan($data->UserZone, $codloan);
                $branch = TB_Branchs::find($data->CRLOCAT)->first();
                $contasset = Pact_Indentures_Assets::where('PactCon_id', $data->dataPact_id)->first();
                if ($contasset->exists()) {
                    $contasset = $contasset->IndenAssetToAsset;
                } else {
                    $contasset = null;
                }

                $view = \View::make('backend.content-report.section-payments.close-AC-approve', compact('codloan', 'data', 'company', 'branch', 'contasset'));
                $html = $view->render();
                $pdf = new PDF('P', 'mm', 'A4', true, 'UTF-16');
                //$pdf::SetTitle('หนังสือยืนยันบอกเลิกสัญญา');
                //$pdf::SetMargins(12.7, 12.7, 12.7);
                $pdf::AddPage();
                $pdf::SetAutoPageBreak(true, 10); // ตั้งค่าให้ไม่มีขอบล่าง
                $pdf::SetFont('thsarabun', '', 16, '', true);
                $pdf::SetCellPadding(0);
                //$pdf::SetAutoPageBreak(TRUE, 20);
                $pdf::WriteHTML($html, true, false, true, false, '');

                // กำหนดสไตล์สำหรับเส้นและกรอบ
                $pdf::SetDrawColor(0, 0, 0); // สีดำ
                $pdf::SetLineWidth(0.2); // ความหนาของเส้น

                // กำหนดขนาดและตำแหน่งของกรอบสี่เหลี่ยมมุมมน
                $signatureWidth = 50;
                $signatureHeight = 20;
                $totalWidth = 3 * $signatureWidth + 2 * 5; // รวมความกว้างของทั้งสามกรอบและช่องว่างระหว่างกรอบ
                $startX = ($pdf::GetPageWidth() - $totalWidth) / 2; // จัดกลาง
                $y = $pdf::GetPageHeight() - 35; // ตำแหน่ง Y ที่คงที่ใกล้กับขอบล่าง

                $x = $startX; // เริ่มจากตำแหน่งที่คำนวณได้
                $signature_text = ["ผู้ซื้อ (ลูกค้า)", "ผู้ตรวจสอบ", "ผู้อนุมัติ"];

                // วาดกรอบสี่เหลี่ยมมุมมนและเส้นแนวนอน
                for ($i = 0; $i < 3; $i++) {
                    $pdf::RoundedRect($x, $y, $signatureWidth, $signatureHeight, 2, '1111', 'D');
                    $lineWidth = $signatureWidth * 0.8; // เส้นยาวกว่าความกว้างของกรอบ 80%
                    $lineX = $x + ($signatureWidth - $lineWidth) / 2; // จัดตำแหน่งเส้นให้อยู่กลางกรอบ
                    $pdf::Line($lineX, $y + ($signatureHeight * 0.5), $lineX + $lineWidth, $y + ($signatureHeight * 0.5));

                    // เพิ่มข้อความใต้เส้น จัดกลางในกรอบ
                    $pdf::SetXY($x, $y + ($signatureHeight * 0.575));
                    $pdf::MultiCell($signatureWidth, $signatureHeight * 0.5, $signature_text[$i], 0, 'C', false);

                    $x += $signatureWidth + 5; // ขยับไปทางขวาสำหรับกรอบถัดไป
                }

                $pdf::Output('ReportTerminate.pdf');
            }
        } elseif ($request->page == 'rp-seized') {
            $DateLetter = $request->DateLetter;
            $dataArr = [
                "DateLetter" => $request->DateLetter,
                "SellPlace" => $request->SellPlace,
                "DateSell" => $request->DateSell,
                "TimeSell" => $request->TimeSell,
                "prices" => $request->prices,
                "loss" => $request->loss,
                "expenses" => $request->expenses,
                "totalSell" => $request->totalSell,
                "Employee" => $request->Employee,
                "memo" => $request->memo,
            ];
            $DataPact = $request->DataPact;
            $status = $request->status;
            $type = $request->type;
            $typeReport = $request->typeReport;
            $codloan = $request->codloan;
            $getCompany = TB_Company::where('Company_Type', $codloan)->where('Company_Zone', auth()->user()->zone)->first();
            $dataPact = Pact_Contracts::find($request->DataPact);
            $dataUser = User::where('zone', Auth()->user()->zone)->get();

            if ($status) {
                $view = \View::make('backend.content-temp.section-seized.report', compact('status', 'typeReport', 'getCompany', 'dataArr', 'dataPact'));
                $html = $view->render();
                $pdf = new PDF();
                $pdf::SetTitle('หนังสือยืนยันบอกเลิกสัญญา');
                $pdf::AddPage('P', 'A4');
                $pdf::SetMargins(5, 5, 5, 0);
                $pdf::SetFont('thsarabun', '', 15, '', true);
                $pdf::SetAutoPageBreak(TRUE, 20);
                $pdf::WriteHTML($html, true, false, true, false, '');
                $pdf::Output('ReportTerminate.pdf');
            }
            return view('backend.content-temp.section-seized.modal-report', compact('type', 'DataPact', 'dataUser'));
        } elseif ($request->page == 'billingstmt') {
            // กดปริ้นต์จากปุ่มฟอร์ม ปริ้นตตามรายการของฟอร์ม
            if ($request->mode == 'all') {
                if (!empty($request->ID_LOCAT)) {
                    $locat = $request->ID_LOCAT;
                } else {
                    $locat = null;
                }
                $zone = \Auth::user()->zone;
                if (!empty($request->DueDT_start)) {
                    $due_start = convertDateHumanToPHP($request->DueDT_start);
                } else {
                    $due_start = null;
                }
                if (!empty($request->DueDT_end)) {
                    $due_end = convertDateHumanToPHP($request->DueDT_end);
                } else {
                    $due_end = null;
                }
                if (!empty($request->CONTNO)) {
                    $contno = $request->CONTNO;
                } else {
                    $contno = null;
                }
                //dd($locat, $zone, $due_start, $due_end, $contno);
                //---------------------------------------------------------------
                $data = DB::table('View_InvoiceDetail')
                    ->whereBetween('DUEDATE', [$due_start, $due_end]);
                if ($locat != null) {
                    $data->where('LOCAT', 'like', $locat);
                }
                $data->where('Company_Zone', 'like', $zone);
                if ($contno != null) {
                    $data->where('CONTNO', 'like', $contno);
                }
                $data = $data->orderBy('CONTNO')->get();
    
                //dd($data);
                //---------------------------------------------------------
                $pdf = new PDF('P', 'mm', 'A4', true, 'UTF-16');
                $pdf::SetTitle('ใบแจ้งการชำระเงินค่างวด');
                $pdf::AddPage();
                $pdf::SetMargins(12.7, 12.7, 12.7);
                $pdf::SetFont('thsarabun', '', 16, '', true);
                $pdf::SetCellPadding(0);
                $pdf::SetAutoPageBreak(TRUE, 10);
    
                //dd($data);
    
                foreach ($data as $key => $value) {
                    $_data = $value;
                    $id = $value->id;
                    $user_zone = auth()->user()->zone;
                    $PactCon_id = $request->PactCon_id;
                    $pact_con = Pact_Contracts::where('Contract_Con', $value->CONTNO)->first();
    
                    $ref_price = '0';
                    $taxCom = $value->Company_Id;
                    $ComBranch = $value->Company_Branch;
                    $tax_id = '|' . $taxCom;
                    $contract = preg_replace("/[^a-z\d]/i", '', @$pact_con->Contract_Con);
                    $ref_code1 = $contract;
                    $ref_code2 = '006';
                    if ($user_zone == '50' || ($user_zone == '30' && $value->typecon == '01')) { //  BarCode สุราษฎร์ ไม่มี ref2
                        $Bar = $tax_id . sprintf("%02d", $ComBranch) . chr(13) . $contract . chr(13) . '' . chr(13) . $ref_price;
                        $ref_code2 = '';
                    } else {
                        $Bar = $tax_id . sprintf("%02d", $ComBranch) . chr(13) . $contract . chr(13) . '006' . chr(13) . $ref_price;
                    }
    
                    $NamepathBr = 'Br_' . $user_zone . '_' . $contract;
                    $Bc_JPGgenerator = new Picqer\Barcode\BarcodeGeneratorPNG();
                    file_put_contents(public_path() . '/cache_barcode/' . $NamepathBr . '.png', $Bc_JPGgenerator->getBarcode($Bar, $Bc_JPGgenerator::TYPE_CODE_128));
    
                    $NamepathQr = 'Qr_' . $user_zone . '_' . $contract;
                    $BQ_generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                    file_put_contents(public_path() . '/cache_barcode/' . $NamepathQr . '.svg', QrCode::size(100)->generate($Bar));
                    //
    
                    $view = \View::make('backend.content-report.section-temp.billing-stmt', compact('_data', 'NamepathBr', 'Bar', 'NamepathQr', 'ref_code1', 'ref_code2'));
                    $html = $view->render();
    
                    $pdf::WriteHTML($html, true, false, true, false, '');
    
    
                }
    
                $pdf::Output('ReportBillingStmt.pdf');
            } else if ($request->mode == 'item') {
                // ปริ้นต์ตามรายการไอดีที่เลือก
                dd($request);
            }
            
        }
    }

    private function generateQr_BarCode($cont, $typecont, $compId, $CompBranch, $userzone)
    {
        $ref_price = '0';
        $tax_id = '|' . $compId;

        $contract = preg_replace("/[^a-z\d]/i", '', $cont);
        if ($userzone == '50' || ($userzone == '30' && $typecont == '01')) { //  BarCode สุราษฎร์ ไม่มี ref2
            $Bar = $tax_id . sprintf("%02d", $CompBranch) . chr(13) . $contract . chr(13) . '' . chr(13) . $ref_price;
        } else {
            $Bar = $tax_id . sprintf("%02d", $CompBranch) . chr(13) . $contract . chr(13) . '006' . chr(13) . $ref_price;
        }

        $NamepathBr = 'Br_' . $userzone . '_' . $contract;
        $Bc_JPGgenerator = new Picqer\Barcode\BarcodeGeneratorPNG();
        file_put_contents(public_path() . '/cache_barcode/' . $NamepathBr . '.png', $Bc_JPGgenerator->getBarcode($Bar, $Bc_JPGgenerator::TYPE_CODE_128));

        $NamepathQr = 'Qr_' . $userzone . '_' . $contract;
        $BQ_generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        file_put_contents(public_path() . '/cache_barcode/' . $NamepathQr . '.svg', QrCode::size(100)->generate($Bar));

        $_namefile = [$NamepathBr, $NamepathQr, $Bar];
        return $_namefile;
    }
}
