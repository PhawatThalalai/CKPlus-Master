<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;

class LockerController extends Controller
{
    public function getBranch() {
        try {
            $response = TB_Branchs::all();

            return response()->json([
                "message" => "getBranch successfully",
                "body" => $response
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
