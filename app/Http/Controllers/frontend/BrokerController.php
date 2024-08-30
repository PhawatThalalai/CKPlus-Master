<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\TB_Constants\TB_Prefix;

use App\Models\TB_DataBroker\Data_Brokers;

class BrokerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->type == 1) {
            $data = Data_Brokers::where('id',599)->first();

            $flag = 'd-none';
            $page = 'Broker';
            $type = $request->type;
            return view('frontend.content-broker.view-broker', compact('type','flag','page','data'));
        }
    }

    public function edit(Request $request, $id) {
        if ($request->type == 1) {
            $data = Data_Brokers::where('id',$id)->first();
            $TBPrefix = TB_Prefix::queryPrefix();

            $type = $request->type;
            $page = 'Broker';
            $title = 'ข้อมูลผู้แนะนำ (Broker Details)';
            return view('frontend.content-broker.edit-broker',compact('data','TBPrefix','page','title','page'));
        }
    }

    public function update(Request $request, $id)
    {
       if ($request->type == 1) {
            dd('Broker');
       }
    }
}
