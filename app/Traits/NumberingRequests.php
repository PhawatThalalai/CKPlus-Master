<?php

namespace App\Traits;

use DB;

trait NumberingRequests
{
    /**
     * Get users by roles
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function runBillTags($tx_date, $tx_header, $tx_zone)
    {
        $dataBill = DB::select("SELECT dbo.uft_runbillTag(?,?,?)", [$tx_date, $tx_header, $tx_zone]);
        $txtbill = json_decode(json_encode($dataBill), true);
        $Billno = $txtbill[0][''];

        return $Billno;
    }

    public function runContracts($tx_date, $tx_zone, $tx_typecont, $tx_branch)
    {
        $dataCont = DB::select("SELECT dbo.uft_runContract(?,?,?,?)", [$tx_date, $tx_zone, $tx_typecont, $tx_branch]);
        $txtCont = json_decode(json_encode($dataCont), true);
        $code = $txtCont[0][''];

        return $code;
    }

    public function runCredoCode($customer_id, $telphone, $deviceId, $deviceName, $platform, $details)
    {
        try {
            DB::statement("EXEC dbo.sp_CrtCusCredo ?,?,?,?,?,?,?", [date('Y-m-d'), $customer_id, $telphone, $deviceId, $deviceName, $platform, $details]);
        } catch (\Exception $e) {
            return null;
        }

        $credo = DB::table('Data_CredoCodes')->where('data_customer_id', $customer_id)->where('credo_flag', 'N')->value('credo_code');
        return $credo ?? null;
    }
}