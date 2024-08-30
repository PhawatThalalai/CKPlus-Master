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

class CenterController extends Controller
{
    public function index(Request $request)
    {    
        // dd($request);
        if ($request->type == 1) {     //ค่าคงที
            $type = $request->type;
            $modalID = $request->modalID;
            $FlagBtn = $request->FlagBtn;

            if ($request->FlagBtn == 'PAYTYP') {      
                $data = TB_PAYTYP::generatePaycode();
                
                $title = 'รหัสชำระโดย';
                return response()->view('components.content-constant.data-search', compact('type','FlagBtn','data','title','modalID'));
            }
            if ($request->FlagBtn == 'PAYFOR') {      
                $data = TB_PAYFOR::generatePaycode();
                $title = 'รหัสรับชำระ';
                return response()->view('components.content-constant.data-search', compact('type','FlagBtn','data','title','modalID'));
            }
            elseif ($request->FlagBtn == 'OLDSTAT' or $request->FlagBtn == 'NEWSTAT' or $request->FlagBtn == 'CONTSTAT') {      
                $data = TB_TYPCONT::generateQuery();
                $title = 'รหัสสถานะ';
            }
            elseif($request->FlagBtn == 'FOLCODE'){
                $data = User::where('zone',auth()->user()->zone)
                        // ->WhereIn('position',['FINANCE','STAFF'])
                        ->get();
                $title = 'รหัสทีมติดตาม';
            }
            elseif($request->FlagBtn == 'PAYBY'){
                $data = TB_PAYTYP::generatePayType();
                $title = 'รหัสชำระ';
            }

            $modalID = $request->modalID;
            $type = $request->type;
            $FlagBtn = $request->FlagBtn;
            return response()->view('components.content-constant.data-search', compact('type','FlagBtn','data','title','modalID'));
        }
    }
}
