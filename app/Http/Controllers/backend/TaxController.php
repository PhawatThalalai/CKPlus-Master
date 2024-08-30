<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use Illuminate\Http\Request;
use DB;
use Log;
use PDF;

use App\Models\TB_PactContracts\Pact_Contracts;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->page == 'invoice-normal') {
            $UserBranch = null;
            if ($request->data['CONTNO'] != null) {
                $pact = Pact_Contracts::where('Contract_Con', $request->data['CONTNO'])->first();
                if ($pact->CodeLoan_Con == '01') {     //เงินกู้
                    $contract = $pact->ContractToConHP;
                } else {                                              //เช่าซื้อ
                    $contract = $pact->ContractToConPSL;
                }
                $UserBranch = $pact->UserBranch;
            }
            $hbranch = TB_Branchs::where('Zone_Branch', auth()->user()->zone)
                ->where('Head_Office', 'yes')->first();

            DB::beginTransaction();
            try {
                $statement = DB::statement(
                    "EXEC dbo.Sp_GenTaxDue ?,?,?,?,?,?",
                    [
                        ($request->data['CONTNO'] != null) ? $request->data['CONTNO'] : '%',     //@pr_contno
                        (@$UserBranch != null) ? @$UserBranch : '%',                             //@pr_locat
                        // $request->data['LOCAT'],
                        // $request->data['HLOCAT'],                                            //@pr_Hlocat
                        $hbranch->id,                                            //@pr_Hlocat
                        convertDateHumanToPHP($request->data['tax_startdate']),              //@pr_fddate
                        convertDateHumanToPHP($request->data['tax_enddate']),                //@pr_tddate
                        auth()->user()->zone                                                 //@pr_zone
                    ]
                );
                // dd($statement);
                $CODENUM = DB::select("SELECT INPDT,COUNT(INPDT) as NUM FROM PatchHP_Taxtran WHERE INPDT = (SELECT MAX(CAST(INPDT AS DATE)) FROM PatchHP_Taxtran WHERE TAXTYP = 'D' AND UserZone = '" . auth()->user()->zone . "') GROUP BY INPDT");
                $DATE_TAX = @$CODENUM[0]->INPDT;
                $NUM_TAX = @$CODENUM[0]->NUM;

                $message = auth()->user()->name . " Process ใบกำกับค่างวดปกติ" . " สร้างจากวันที่ " . $request->data['tax_startdate'] . " ถึงวันที่ " . $request->data['tax_enddate'];
                Log::build([
                    'driver' => 'daily',
                    'path' => storage_path('logs/backend/tax/data_tax.log'),
                ])->info($message);

                DB::commit();
                // return $NUM_TAX;
                return ['dateTax' => $DATE_TAX, 'numTax' => $NUM_TAX];
            } catch (\Exception $e) {
                DB::rollback();
                Log::channel('daily')->error($e->getMessage());
                return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
            }
        } elseif ($request->page == 'invoice-before') {
            $UserBranch = null;
            if ($request->data['CONTNO'] != null) {
                $pact = Pact_Contracts::where('Contract_Con', $request->data['CONTNO'])->first();
                if ($pact->CodeLoan_Con == '01') {     //เงินกู้
                    $contract = $pact->ContractToConHP;
                } else {                                              //เช่าซื้อ
                    $contract = $pact->ContractToConPSL;
                }
                $UserBranch = $pact->UserBranch;
            }
            DB::beginTransaction();
            try {
                $statement = DB::statement(
                    "EXEC dbo.Sp_GenTaxBeforDue ?,?,?,?,?,?",
                    [
                            // $request->data['CONTNO'],
                            // auth()->user()->branch,
                            // auth()->user()->branch,
                            // convertDateHumanToPHP($request->data['tax_startdate']),
                            // convertDateHumanToPHP($request->data['tax_enddate']),
                            // auth()->user()->zone
                        ($request->data['CONTNO'] != null) ? $request->data['CONTNO'] : '%',     //@pr_contno
                        (@$UserBranch != null) ? @$UserBranch : '%',                             //@pr_locat
                        // $request->data['LOCAT'],
                        $request->data['HLOCAT'],                                            //@pr_Hlocat
                        convertDateHumanToPHP($request->data['tax_startdate']),              //@pr_fddate
                        convertDateHumanToPHP($request->data['tax_enddate']),                //@pr_tddate
                        auth()->user()->zone                                                 //@pr_zone
                    ]
                );
                // dd($statement);
                $CODENUM = DB::select("SELECT INPDT,COUNT(INPDT) as NUM FROM PatchHP_Taxtran WHERE INPDT = (SELECT MAX(CAST(INPDT AS DATE)) FROM PatchHP_Taxtran WHERE TAXTYP = 'B' AND UserZone = '" . auth()->user()->zone . "') GROUP BY INPDT");
                $DATE_TAX = @$CODENUM[0]->INPDT;
                $NUM_TAX = @$CODENUM[0]->NUM;

                $message = auth()->user()->name . " Process ใบกำกับค่างวดก่อนดิว" . " สร้างจากวันที่ " . $request->data['tax_startdate'] . " ถึงวันที่ " . $request->data['tax_enddate'];
                Log::build([
                    'driver' => 'daily',
                    'path' => storage_path('logs/backend/tax/data_tax.log'),
                ])->info($message);

                DB::commit();
                // return $NUMTAX;
                return ['dateTax' => $DATE_TAX, 'numTax' => $NUM_TAX];
            } catch (\Exception $e) {
                DB::rollback();
                Log::channel('daily')->error($e->getMessage());
                return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
            }
        } elseif ($request->page == 'print-invoice-normal') {
            $page = 'invoice-normal';
            return view('backend.content-tax.modal-tax', compact('page'));
        } elseif ($request->page == 'print-invoice-before') {
            $page = 'invoice-before';
            return view('backend.content-tax.modal-tax', compact('page'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if($request->page == 'invoice-normal'){
            $start = convertDateHumanToPHP($request->start);
            $end = convertDateHumanToPHP($request->end);
            $data = DB::table('PatchHP_Taxtran')
                ->join('TB_Branchs', 'PatchHP_Taxtran.LOCAT', '=', 'TB_Branchs.id')
                ->whereBetween('INPDT', [convertDateHumanToPHP($request->start) . ' 00:00:00.000', convertDateHumanToPHP($request->end) . ' 23:59:00.000'])
                ->where('DECP', 'ค่างวด')
                ->get();

            if(@$request->type == 'PDF'){
                $view = \View::make('backend.content-report.section-invoice.viewpdfNormal', compact('data','start','end'));
                $html = $view->render();
                $pdf = new PDF();
                $pdf::SetTitle('หนังสือใบกำกับค่างวดปกติ');
                $pdf::AddPage('L', 'A4');
                $pdf::SetMargins(5, 5, 5, 0);
                $pdf::SetFontSpacing(0);
                $pdf::SetY(1, true, true);
                $pdf::SetFont('thsarabun', '', 14, '', true);
                $pdf::SetAutoPageBreak(TRUE, 20);
                $pdf::WriteHTML($html, true, false, true, false, '');
                $pdf::Output('Reportinvoice-normal.pdf');
            }
            elseif(@$request->type == 'EXCEL'){
                dd($request,$data);
            }
        }
        elseif($request->page == 'invoice-before'){
            $start = convertDateHumanToPHP($request->start);
            $end = convertDateHumanToPHP($request->end);
            $data = DB::table('PatchHP_Taxtran')
                ->join('TB_Branchs', 'PatchHP_Taxtran.LOCAT', '=', 'TB_Branchs.id')
                ->whereBetween('INPDT', [convertDateHumanToPHP($request->start) . ' 00:00:00.000', convertDateHumanToPHP($request->end) . ' 23:59:00.000'])
                ->where('DECP', 'รับชำระค่างวด')
                ->get();
            // dd($request,$request->start,$data);
            if(@$request->type == 'PDF'){
                $view = \View::make('backend.content-report.section-invoice.viewpdfBefore', compact('data','start','end'));
                $html = $view->render();
                $pdf = new PDF();
                $pdf::SetTitle('หนังสือใบกำกับค่างวดก่อนดิว');
                $pdf::AddPage('L', 'A4');
                $pdf::SetMargins(5, 5, 5, 0);
                $pdf::SetFontSpacing(0);
                $pdf::SetY(1, true, true);
                $pdf::SetFont('thsarabun', '', 15, '', true);
                $pdf::SetAutoPageBreak(TRUE, 20);
                $pdf::WriteHTML($html, true, false, true, false, '');
                $pdf::Output('Reportinvoice-before.pdf');
            }
            elseif(@$request->type == 'EXCEL'){
                dd($request,$data);
            }
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
