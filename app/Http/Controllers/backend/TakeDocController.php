<?php

namespace App\Http\Controllers\backend;

// models
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_Contracts;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_Contracts;
use App\Models\TB_DOC\TAKE_DOC;
use App\Models\TB_DOC\TYPE_TAKE_DOC;

//lib
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TakeDocController extends Controller
{
    public function index (Request $req) {
        $page = @$req->page !== null ? $req->page : null;
        $data = $req->data;
        $Fdate = empty($data['Fdate']) ? null : $data['Fdate'];
        $Tdate = empty($data['Tdate']) ? null : $data['Tdate'];
        $userBranch = auth()->user()->branch;
        $userZone = auth()->user()->zone;
        $userId = auth()->user()->id;

        $timestamp_F = strtotime($Fdate);
        $Fdate_format = date('Y-m-d', $timestamp_F);
        $timestamp_T = strtotime($Tdate);
        $Tdate_format = date('Y-m-d', $timestamp_T);
        $month = date('Y-m', strtotime($Fdate));

        if($page === 'search') {
            try {
                if($data['typeLoan'] === 'PSL') {
                    $response = PatchPSL_Contracts::
                    selectRaw("PatchPSL_Contracts.CONTNO, Pact_AuditTags.Flag_Status, TB_StatusAudits.name_th")
                    ->join('Pact_Contracts', 'PatchPSL_Contracts.DataPact_id', '=', 'Pact_Contracts.id')
                    ->join('Pact_AuditTags', 'Pact_Contracts.id', '=', 'Pact_AuditTags.PactCon_id')
                    ->join('TB_StatusAudits', 'Pact_AuditTags.Flag_Status', '=', 'TB_StatusAudits.id')
                    ->where('PatchPSL_Contracts.CONTNO', $data['CONTNO'])
                    ->whereRaw("Pact_AuditTags.Flag_Status IN (2, 3, 6, 7) AND Pact_AuditTags.Flag_Status IS NOT NULL")
                    ->get();
                } else {
                    $response = PatchHP_Contracts::
                    selectRaw("PatchPSL_Contracts.CONTNO, Pact_AuditTags.Flag_Status, TB_StatusAudits.name_th")
                    ->join('Pact_Contracts', 'PatchPSL_Contracts.DataPact_id', '=', 'Pact_Contracts.id')
                    ->join('Pact_AuditTags', 'Pact_Contracts.id', '=', 'Pact_AuditTags.PactCon_id')
                    ->join('TB_StatusAudits', 'Pact_AuditTags.Flag_Status', '=', 'TB_StatusAudits.id')
                    ->where('PatchPSL_Contracts.CONTNO', $data['CONTNO'])
                    ->whereRaw("Pact_AuditTags.Flag_Status IN (2, 3, 6, 7) AND Pact_AuditTags.Flag_Status IS NOT NULL")
                    ->get();
                }

                if(count($response) <= 0) {
                    throw new \Exception('Data not found');
                }
                
                return response()->json([
                    'message' => 'search data successfully',
                    'body' => $response,
                    'code' => 200,
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'messages' => $e->getMessage(),
                    'code' => $e->getCode(),
                ], 500);
            }   
        } else if ($page === 'list-reqtakeDoc') {
            try {
                $dataList = TAKE_DOC::
                whereRaw("REQTAKE_DT BETWEEN '". $Fdate_format ."' AND '". $Tdate_format ."'")
                ->where('Brance', $userBranch)->get();

                if(count($dataList) <= 0) {
                    throw new \Exception('ไม่พบข้อมูลที่ต้องการหา');
                }

                $resView = view('backend.content-take-doc.list-take-document.table', compact('dataList'))->render();

                return response()->json([
                    "message" => 'Filter data successfully',
                    "resHtml" => $resView,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    "messages" => $e->getMessage(),
                ], 500);
            }
        } else if ($page === 'fecthData') {
            try {
                $response = TYPE_TAKE_DOC::where('id', $data['typeDocId'])->first();

                if(count($response) <= 0) {
                    throw new \Exception('ไม่มีข้อมูลที่ต้องการหา');
                }

                return response()->json([
                    'message' => 'Fetch data successfully',
                    "body" => $response,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], 500);
            }
        }
    }


    public function store(Request $req) {
        $page = @$req->page!== null ? $req->page : null;
        $data = $req->data;
        $userBranch = auth()->user()->branch;
        $userZone = auth()->user()->zone;
        $userId = auth()->user()->id;
        
        $now = Carbon::now('Asia/Bangkok');
        $dateNow = $now->format('Y-m-d');

        if($page === 'takeDoc') {
            try {
                $response = TAKE_DOC::create([
                    "CONTNO" => $data['CONTNO'],
                    "TAKETYPE" => $data['docType'],
                    "NOTE" => $data['note'],
                    "USER_ZONE" => $userZone,
                    "Brance" => $userBranch,
                    "TYPE_Loans" => $data['typeLoan'],
                    "REQTAKE_DT" => $dateNow,
                    "PERSON_TAKE" => $userId,
                ]);

                return response()->json([
                    "message" => "Take document successfully",
                    "boby" => $response,
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    "message" => "Take document failed",
                    "body" => $e->getMessage(),
                ], 500);
            }
        } else if($page === 'createTypeTakeDoc') {
            try {
                $createData = TYPE_TAKE_DOC::create([
                    'name_th' => $data['name_th'],
                    'name_en' => $data['name_en'],
                ]);

                $dataTypeTake = TYPE_TAKE_DOC::all();
                $resView = view('data-system.back-system.conf-type-takedoc.table', compact('dataTypeTake'))->render();

                return response()->json([
                    "message" => "Create type take document successfully",
                    "resHtml" => $resView,
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    "message" => "Create type take document failed",
                ], 500);
            }
        }
    }

    public function edit(Request $req) {
        $page = @$req->page!== null ? $req->page : null;
        $data = $req->data;
        $userBranch = auth()->user()->branch;
        $userZone = auth()->user()->zone;
        $userId = auth()->user()->id;

        if($page === 'edit') {
            dd('test');
        }
    }
}
