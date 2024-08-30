<?php

namespace App\Traits;
use App\Models\api\TB_ConfigverifyR2;

trait JsonResources
{
    /**
     * Get users by roles
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */

    // public function combyneKeys($R1)
    // {
    //     $R2 = TB_ConfigverifyR2::where('code_r1', $R1)->value('code_r2');
    //     if (!$R2) {
    //         $result = $this->formatJsonData('30001', 'accountVerify', 'Data not found', 'Popup', 'ERROR');
    //     }

    //     return $result;
    // }

    public function formatJsonData($code = null, $operation = null, $message = null, $messageType = null, $status = null): array
    {
        $result = [
            'code' => $code,
            'operation' => $operation,
            'message' => $message,
            'messageType' => $messageType,
            'status' => $status,
        ];

        return $result;
    }
}