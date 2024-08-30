<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Log;
use PDF;
use Carbon\Carbon;

use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\TB_Letter\Data_PRINTLET;
use App\Models\TB_Letter\Data_TKANGPAY;
use App\Models\TB_Constants\TB_Frontend\TB_Company;
use App\Models\TB_Constants\TB_Backend\TB_GROUPKANGDUE;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_Contracts;

class LetterController extends Controller
{
    public function index(Request $req) {
        if($req->page == 'saveLet') {
            $Fdate_format = Carbon::parse($req->data['Fdate'])->format('Y-m-d');
            $Tdate_format = Carbon::parse($req->data['Tdate'])->format('Y-m-d');
            try {
                $response = Data_PRINTLET::
                selectRaw("Data_PRINTLET.id, USERID, LOCAT, CONTNO, Prefix, Firstname_Cus, Surname_Cus, PRINTDT, Phone_cus, Name_Cus")
                ->leftJoin("Data_Customers","Data_PRINTLET.USERID","=","Data_Customers.id")
                ->when($req->data['LOCAT'] == 'ALL', function($q) {
                    return $q->whereRaw("LOCAT LIKE '%'");
                })
                ->when($req->data['LOCAT'] != 'ALL', function($q) use ($req) {
                    return $q->whereRaw("LOCAT LIKE '%". $req->data['LOCAT'] ."%'");
                })
                ->whereRaw("PRINTDT BETWEEN '". $Fdate_format ."' AND '". $Tdate_format ."' AND Data_PRINTLET.userzone = '". auth()->user()->zone ."' AND EMSNO IS NULL")->get();

                // =======================================================
                // useRelay
                // =======================================================
                // $response = Data_PRINTLET::
                // selectRaw("USERID, LOCAT, CONTNO, PRINTDT")
                // ->whereRaw("PRINTDT BETWEEN '". $Fdate_format ."' AND '". $Tdate_format ."' AND userzone = '". auth()->user()->zone ."' AND EMSNO IS NULL")->get();

                if(count($response) == 0) {
                    throw new \Exception("ไม่มีข้อมูลที่ต้องการค้นหา");
                }

                $resView = view("backend.content-printlet.save-printlet.data", compact('response', 'Fdate_format', 'Tdate_format'))->render();

                return response()->json([
                    'message' => 'Query successfully',
                    'resHtml' => $resView,
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], 500);
            }
        }
    }     

    //
    public function show(Request $request, $id){
        if($request->page == 'print-letter'){
            if($request->data['FLAG'] != NULL){
                if($request->data['FLAG'] == 'Y'){
                    $data = Data_TKANGPAY::where('userzone',auth()->user()->zone)
                        ->where('FLAG','Y')
                        ->where('FORCODE',$request->data['GCODE'])
                        ->whereBetween('duedate',[convertDateHumanToPHP($request->data['START']),convertDateHumanToPHP($request->data['END'])])
                        ->get();
                }
                elseif($request->data['FLAG'] == 'N'){
                    $data = Data_TKANGPAY::where('userzone',auth()->user()->zone)
                        ->where('FLAG',NULL)
                        ->where('FORCODE',$request->data['GCODE'])
                        ->whereBetween('duedate',[convertDateHumanToPHP($request->data['START']),convertDateHumanToPHP($request->data['END'])])
                        ->get();
                }
            }
            else{
                $data = Data_TKANGPAY::where('userzone',auth()->user()->zone)
                    ->where('FORCODE',$request->data['GCODE'])
                    ->whereBetween('duedate',[convertDateHumanToPHP($request->data['START']),convertDateHumanToPHP($request->data['END'])])
                    ->get();
            }
                    // dd($data);
            $message = auth()->user()->name." Filter ".$request->data['GCODE'];

            Log::build([
                'driver' => 'daily',
                'path' => storage_path('logs/backend/report/data_letter.log'),
            ])->info($message);

            $viewData = view('backend.content-printlet.data-let', compact('data'))->render();
            return response()->json(['viewData' => $viewData], 200);
        }
        else if($request->page == 'print-form'){
            $contnoArray = explode(',', rtrim($request->contno, ','));
            $data = Data_PRINTLET::where('userzone',auth()->user()->zone)
                    ->where('GCODE',$request->gcode)
                    ->whereIn('CONTNO',$contnoArray)
                    // ->where('PRINTDT',date('Y-m-d'))
                    // ->whereBetween('PRINTDT',[convertDateHumanToPHP($request->data['start']),convertDateHumanToPHP($request->data['end'])])
                    ->get();

            $message = auth()->user()->name." Print form ".$request->gcode;
            Log::channel('daily')->info($message);
            activity()->log($message);
        }
        else if($request->page == 'reprint-letter'){
            $data = Data_PRINTLET::where('userzone',auth()->user()->zone)
                    ->where('GCODE',$request->data['GCODE'])
                    ->whereBetween('PRINTDT',[convertDateHumanToPHP($request->data['START']),convertDateHumanToPHP($request->data['END'])])
                    ->get();
                    // dd(count($data));
            $gcode = $request->data['GCODE'];
            $start = convertDateHumanToPHP($request->data['START']);
            $end = convertDateHumanToPHP($request->data['END']);
            $countData = count($data);
            $viewData = view('backend.content-printlet.data-printed', compact('data','gcode','start','end','countData'))->render();
            return response()->json(['viewData' => $viewData], 200);
        }
        else if($request->page == 'reprint-form'){
            $data = Data_PRINTLET::where('userzone',auth()->user()->zone)
                    ->where('GCODE',$request->gcode)
                    ->whereBetween('PRINTDT',[convertDateHumanToPHP($request->start),convertDateHumanToPHP($request->end)])
                    ->get();

            $updatedCount = 0;
            foreach ($data as $record) {
                $record->REPRINTID = $record->REPRINTID + 1;
                $record->REPRINTDT = Carbon::now();
                if ($record->save()) {
                    $updatedCount++;
                }
            }

            $pact = Pact_Contracts::where('Contract_Con', $data[0]->CONTNO)->first();

            $message = auth()->user()->name." Print form ".$request->gcode;
            Log::channel('daily')->info($message);
            activity()->log($message);
        }
        else if($request->page == 'reprint-oneform'){
            $data = Data_PRINTLET::where('id',$id)
                    ->where('GCODE',$request->gcode)
                    ->whereBetween('PRINTDT',[convertDateHumanToPHP($request->start),convertDateHumanToPHP($request->end)])
                    ->get();

            $updatedCount = 0;
            foreach ($data as $record) {
                $record->REPRINTID = $record->REPRINTID + 1;
                $record->REPRINTDT = Carbon::now();
                if ($record->save()) {
                    $updatedCount++;
                }
            }

            
        }

        //กำหนดฟอร์มหนังสือตามกลุ่มค้าง
        if($request->gcode == 'P2'){
            $view = \View::make('backend.content-report.PDF.LetterAsk', compact('data'));
            $html = $view->render();
            $pdf = new PDF();
            $pdf::SetTitle('หนังสือทวงถามส่งคนค้ำ');
        }
        elseif($request->gcode == 'P3'){
            $view = \View::make('backend.content-report.PDF.LetterTerminate', compact('data'));
            $html = $view->render();
            $pdf = new PDF();
            $pdf::SetTitle('หนังสือบอกเลิก');
        }
        elseif($request->gcode == 'P4'){
            $view = \View::make('backend.content-report.PDF.LetterNotis', compact('data'));
            $html = $view->render();
            $pdf = new PDF();
            $pdf::SetTitle('หนังสือโนติส');
        }
        $pdf::AddPage('P', 'A4');
        $pdf::SetMargins(10, 0, 0, 0);
        $pdf::SetFont('thsarabun', '', 16, true);
        $pdf::SetY(2, true, true);
        $pdf::SetAutoPageBreak(TRUE, 0);
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('FormContract.pdf');
    }

    public function create(Request $request){
        $Fdate = empty(@$request->data['Fdate']) ? '' : @$request->data['Fdate'];
        $Tdate = empty(@$request->data['Tdate']) ? '' : @$request->data['Tdate'];
        $LOCAT = empty(@$request->data['LOCAT']) ? '' : @$request->data['LOCAT'];

        $Fdate_format = Carbon::parse(@$Fdate)->format('Y-m-d');
        $Tdate_format = Carbon::parse(@$Tdate)->format('Y-m-d');

        if(@$request->page == 'print-letter'){
            $GCODE = TB_GROUPKANGDUE::where('FLAG','Y')->get();
            return view('backend.content-printlet.modal-let',compact('GCODE'));
        } else if(@$request->page == 'edit-save-letter'){
            $page = 'edit-save-letter';
            $response = Data_PRINTLET::
            when($request->LOCAT == 'ALL', function($q) {
                return $q->whereRaw("LOCAT LIKE '%'");
            })
            ->when($request->LOCAT!= 'ALL', function($q) use ($LOCAT) {
                return $q->whereRaw("LOCAT LIKE '%". $LOCAT ."%'");
            })
            ->whereBetween('PRINTDT', [$Fdate_format, $Tdate_format])
            ->where("EMSNO", "IS", NULL)->get();

            $resView = view("backend.content-printlet.save-printlet.data", compact('response', 'Fdate_format', 'Tdate_format', 'page'))->render();

            return response()->json([
                'message' => 'Query successfully',
                "resHtml" => $resView,
            ], 200);
        }
    }

    public function store(Request $request){
        if($request->page == 'print-letter'){
            $StrCon = explode(",",$request->getContno);  
            $StrID = explode(",",$request->getid);  
            DB::beginTransaction();
            try {
                for ($i=0; $i < (count($StrCon)-1); $i++) {
                    $dataLetter = Data_PRINTLET::updateOrCreate(
                        [
                            'CONTNO' => $StrCon[$i],
                            'GCODE' => $request->getGcode,
                        ],
                        [
                            'TKANGPAY_ID' => $StrID[$i],
                            'LOCAT' => $request->getLocat,
                            'LETDOC' => $this->LETDOC(),
                            'CONTNO' => $StrCon[$i],
                            'GCODE' => $request->getGcode,
                            'PRINTDT' => date('Y-m-d'),
                            'PRNNO' => '1',
                            'USERID' => auth()->user()->id,
                            'userzone' => auth()->user()->zone,
                        ]
                    );
                }
                $message = auth()->user()->name." Store ".$request->getGcode;
                Log::channel('daily')->notice($message);
                DB::commit();
            }catch (\Exception $e) {
                DB::rollback();
                Log::channel('daily')->error($e->getMessage());
                // return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
            }
        } else if($request->page == 'saveLetter'){
            try {
                $page = $request->resHtml;
                $timestamp = Carbon::now();
                $data = $request->data;

                foreach ($data as $key => $value) {
                    if (is_string($key)) {
                        unset($data[$key]);
                    }
                }

                foreach ($data as $key => $value) {
                    $dateSend = Carbon::parse(@$request->data["DATE_EMS_{$key}"])->format('Y-m-d');
                    $EMSNO    = (@$request->data["EMS_{$key}"]." ".@$request->data["EMSNO_{$key}"]." ".@$request->data["verify_{$key}"]." ".@$request->data["{$key}"]);
        
                    Data_PRINTLET::whereRaw("id = '" . $key . "'")->update([
                        'EMSNO'     => @$EMSNO,
                        'EMSSENDT'  => @$dateSend,
                        'EMSsDT'    => @$timestamp,
                    ]);
                }
                
                // return response()->json([
                //     'message' => 'save letter successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        } else if ($request->page == 'edit-saveLetter') {
            try{
                
            }catch (\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ], 500);
            }
        }
    }

    private function LETDOC()
    {
        $code = Data_PRINTLET::orderBy('id','desc')->first();
        if ($code == NULL) {
            $Letdoc = 'PRN-' . '00000001';
        } else {
            $StrNum = substr($code->LETDOC, -8) + 1;
            $num = "10000000";
            $SubStr = substr($num.$StrNum, -8);
            $Letdoc = 'PRN-'.$SubStr;
        }
        return $Letdoc;
    }
}
