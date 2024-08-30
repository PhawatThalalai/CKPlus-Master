<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\User;

use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_Constants\TB_Frontend\TB_BankAccounts;
use App\Models\TB_Constants\TB_Backend\TB_TYPCONT;
use App\Models\TB_Constants\TB_Backend\TB_PAYTYP;
use App\Models\TB_Constants\TB_Backend\TB_PAYFOR;

use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_paydue;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_paydue;

class ConstantController extends Controller
{
    public function index(Request $request)
    {
        if ($request->page == 'frontend') {
            if ($request->module = 'select-branch') {
                $data = TB_Branchs::select('id', 'Name_Branch', 'NickName_Branch')
                    ->where('Zone_Branch', $request->zone)
                    ->where('Branch_Active', 'yes')
                    ->orderBY('id_Contract', 'asc')
                    ->get()->toArray();

                return response()->json($data);
            }
        } elseif ($request->page == 'backend') {
            if ($request->code == 'PAYTYP_CODE') {
                $data = TB_PAYTYP::where('STATUS', 'Y')->where('PAYCODE', $request->GetVal)->first();
            } elseif ($request->code == 'PAYFOR_CODE') {
                $data = TB_PAYFOR::where('STATUS', 'Y')->where('FORCODE', $request->GetVal)->first();
            } elseif ($request->code == 'OLDSTAT' or $request->code == 'NEWSTAT' or $request->code == 'CONTSTAT') {
                $data = TB_TYPCONT::where('FLAG', 'yes')->where('CONTTYP', $request->GetVal)->first();
            } elseif ($request->code == 'FOLCODE' or $request->code == 'SALECODE') {
                $data = User::where('zone', auth()->user()->zone)
                    ->where('id', $request->GetVal)
                    ->first();
            }

            return response()->json(['data' => $data]);
        }
    }

    public function create(Request $request)
    {
        if ($request->page == 'frontend') {
            # code...
        } elseif ($request->page == 'backend') {
            $type = $request->type;
            $modalID = $request->modalID;
            $FlagBtn = $request->FlagBtn;

            if ($request->FlagBtn == 'PAYTYP') {
                $data = TB_PAYTYP::generatePayType();

                $title = 'รหัสชำระโดย';
                return response()->view('components.content-constant.data-search', compact('type', 'FlagBtn', 'data', 'title', 'modalID'));
            } elseif ($request->FlagBtn == 'PAYFOR') {
                $data = TB_PAYFOR::generatePaycode();

                $title = 'รหัสรับชำระ';
                return response()->view('components.content-constant.data-search', compact('type', 'FlagBtn', 'data', 'title', 'modalID'));
            } elseif ($request->FlagBtn == 'PAYINACC') {
                $data = TB_BankAccounts::where('Inside_Active', 'yes')
                    ->where('User_Zone', $request->zone)
                    ->where('company_type', $request->comType)
                    ->orderBY('id', 'asc')
                    ->get();

                $title = 'รหัสธนาคาร';
                return response()->view('components.content-constant.data-search', compact('type', 'FlagBtn', 'data', 'title', 'modalID'));
            } elseif ($request->FlagBtn == 'FOLCODE') {
                $data = User::where('zone', auth()->user()->zone)->get();

                $title = 'เจ้าหน้าที่ติดตาม';
                return response()->view('components.content-constant.data-search', compact('type', 'FlagBtn', 'data', 'title', 'modalID'));
            } elseif ($request->FlagBtn == 'SALECODE') {
                $data = User::where('zone', auth()->user()->zone)->get();

                $title = 'เจ้าหน้าที่เก็บเงิน';
                return response()->view('components.content-constant.data-search', compact('type', 'FlagBtn', 'data', 'title', 'modalID'));
            } elseif ($request->FlagBtn == 'OLDSTAT' or $request->FlagBtn == 'NEWSTAT' or $request->FlagBtn == 'CONTSTAT') {
                $data = TB_TYPCONT::generateQuery();
                $title = 'รหัสสถานะ';
                return response()->view('components.content-constant.data-search', compact('type', 'FlagBtn', 'data', 'title', 'modalID'));
            } elseif ($request->FlagBtn == 'LOCAT') {
                $data = TB_Branchs::where('Zone_Branch', auth()->user()->zone)
                    ->where('Branch_Active', 'yes')
                    ->orderBY('id_Contract', 'asc')
                    ->get();

                $title = 'สาขา';
                return response()->view('components.content-constant.data-search', compact('type', 'FlagBtn', 'data', 'title', 'modalID'));
            } elseif ($request->FlagBtn == 'USERS') {
                $data = User::where('zone', auth()->user()->zone)
                    ->where('status', 'yes')
                    ->get();

                $title = 'พนักงาน';
                return response()->view('components.content-constant.data-search', compact('type', 'FlagBtn', 'data', 'title', 'modalID'));
            }
        }
    }
}
