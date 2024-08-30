<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\api\TB_ConfigverifyR2;
use App\Models\api\user_api;

use App\Http\Resources\AccountLoanCollection;
use App\Http\Resources\InvoicesCollection;
use App\Http\Resources\InvoiceDetailResources;
use App\Http\Resources\ReceiptCollection;
use App\Http\Resources\ReceiptDetailResources;
use App\Http\Resources\PaymentDetailResources;

use App\Traits\JsonResources;

class LoansController extends Controller
{
    use JsonResources;

    public function LeasingAccount()
    {
        $R1 = request()->header('r1');
        $R2 = TB_ConfigverifyR2::where('code_r1', $R1)->value('code_r2');
        if (!$R2) {
            $responseStatus = $this->formatJsonData('30001', 'getLeasingAccount', 'Data not found with R2', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }

        $user = user_api::where('token', request()->header('token'))
            ->with([
                'view_leasingAcct' => function ($query) {
                    $query->orderBy('totalBalance', 'desc');
                }
            ])->first();

        if ($user) {
            if (request()->only(['accountId']) != null) {
                $user->view_leasingAcct = $user->view_leasingAcct()->where('accountId', request()->only('accountId'))->orderBy('totalBalance', 'desc')->get();
            }

            $responseStatus = $this->formatJsonData('00000', 'getLeasingAccount', '', '', 'SUCCESS');
            return response()->json([
                'responseStatus' => $responseStatus,
                'data' => new AccountLoanCollection($user->view_leasingAcct, $R1, $R2)
            ], 200);

        } else {
            $responseStatus = $this->formatJsonData('30001', 'getLeasingAccount', 'Data not found', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }
    }

    public function InvoiceHistory()
    {
        $token = request()->header('token');
        $credentials = request()->only(['accountId']);

        if (!$token || !$credentials['accountId']) {
            $responseStatus = $this->formatJsonData('20001', 'invoiceHistory', 'input validated', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }

        $user = user_api::where('token', $token)
            ->with([
                'view_invoice' => function ($query) use ($credentials) {
                    $query->where('accountId', $credentials['accountId'])
                        ->select('accountId', 'invoiceId', 'invoiceDate', 'invoiceYear', 'customerId');
                }
            ])
            ->first();

        if ($user->view_invoice->isNotEmpty()) {
            $responseStatus = $this->formatJsonData('00000', 'invoiceHistory', '', '', 'SUCCESS');
            return response()->json([
                'responseStatus' => $responseStatus,
                'data' => new InvoicesCollection($user->view_invoice)
            ], 200);
        } else {
            $responseStatus = $this->formatJsonData('30001', 'invoiceHistory', 'ไม่พบข้อมูลที่ต้องการเรียก', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }
    }

    public function InvoiceDetail()
    {
        $R1 = request()->header('r1');
        $R2 = TB_ConfigverifyR2::where('code_r1', $R1)->value('code_r2');
        if (!$R2) {
            $responseStatus = $this->formatJsonData('30001', 'invoiceDetail', 'Data not found with R2', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }

        $token = request()->header('token');
        $credentials = request()->only(['accountId', 'invoiceId']);

        if (!$token || in_array(null, $credentials, true)) {
            $responseStatus = $this->formatJsonData('20001', 'invoiceDetail', 'input validated', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }

        $user = user_api::where('token', $token)
            ->with([
                'view_invoiceDetail' => function ($query) use ($credentials) {
                    $query->where('accountId', $credentials['accountId'])
                        ->where('invoiceId', $credentials['invoiceId']);
                }
            ])
            ->first();

        if ($user->view_invoiceDetail != null) {
            $responseStatus = $this->formatJsonData('00000', 'invoiceDetail', '', '', 'SUCCESS');
            return response()->json([
                'responseStatus' => $responseStatus,
                'data' => new InvoiceDetailResources($user->view_invoiceDetail, $R1, $R2)
            ], 200);
        } else {
            $responseStatus = $this->formatJsonData('30001', 'invoiceDetail', 'Data not found', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }
    }

    public function ReceiptHistory()
    {
        $token = request()->header('token');
        $credentials = request()->only(['accountId']);

        if (!$token || !$credentials['accountId']) {
            $responseStatus = $this->formatJsonData('20001', 'receiptHistory', 'input validated', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }

        $user = user_api::where('token', $token)
            ->with([
                'view_receipt' => function ($query) use ($credentials) {
                    $query->where('accountId', $credentials['accountId'])
                        ->select('accountId', 'receiptId', 'receiptDate', 'receiptYear', 'customerId', 'receiptAmount');
                }
            ])
            ->first();

        if ($user->view_receipt->isNotEmpty()) {
            $responseStatus = $this->formatJsonData('00000', 'receiptHistory', '', '', 'SUCCESS');
            return response()->json([
                'responseStatus' => $responseStatus,
                'data' => new ReceiptCollection($user->view_receipt)
            ], 200);
        } else {
            $responseStatus = $this->formatJsonData('30001', 'receiptHistory', 'ไม่พบข้อมูลที่ต้องการเรียก', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }
    }

    public function ReceiptDetail()
    {
        $R1 = request()->header('r1');
        $R2 = TB_ConfigverifyR2::where('code_r1', $R1)->value('code_r2');
        if (!$R2) {
            $responseStatus = $this->formatJsonData('30001', 'receiptDetail', 'Data not found with R2', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }

        $token = request()->header('token');
        $credentials = request()->only(['accountId', 'receiptId']);

        if (!$token || in_array(null, $credentials, true)) {
            $responseStatus = $this->formatJsonData('20001', 'receiptDetail', 'input validated', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }

        $user = user_api::where('token', $token)
            ->with([
                'view_receiptDetail' => function ($query) use ($credentials) {
                    $query->where('accountId', $credentials['accountId'])
                        ->where('receiptId', $credentials['receiptId']);
                }
            ])
            ->first();
        if ($user->view_receiptDetail != null) {
            $responseStatus = $this->formatJsonData('00000', 'receiptDetail', '', '', 'SUCCESS');
            return response()->json([
                'responseStatus' => $responseStatus,
                'data' => new ReceiptDetailResources($user->view_receiptDetail, $R1, $R2)
            ], 200);
        } else {
            $responseStatus = $this->formatJsonData('30001', 'receiptDetail', 'Data not found', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }
    }

    public function PaymentDetail()
    {
        $R1 = request()->header('r1');
        $R2 = TB_ConfigverifyR2::where('code_r1', $R1)->value('code_r2');
        if (!$R2) {
            $responseStatus = $this->formatJsonData('30001', 'getPaymentData', 'Data not found with R2', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }

        $token = request()->header('token');
        $credentials = request()->only(['accountId', 'amount']);

        if (!$token || in_array(null, $credentials, true)) {
            $responseStatus = $this->formatJsonData('20001', 'getPaymentData', 'input validated', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }


        // $sha256 = hash('sha256', $R1 . $R2);
        // $R3 = substr($sha256, 0, 16);
        // $iv = substr((strrev($sha256)), 0, 16);
        // $encrypted_data = bin2hex(openssl_encrypt($credentials['amount'], "aes-128-gcm", $R3, OPENSSL_RAW_DATA, $iv, $tag)) . bin2hex($tag);
        // dd($encrypted_data);


        $user = user_api::where('token', $token)
            ->with([
                'view_paymentDetail' => function ($query) use ($credentials) {
                    $query->where('accountId', $credentials['accountId']);
                }
            ])
            ->first();

        if ($user->view_paymentDetail != null) {
            $responseStatus = $this->formatJsonData('00000', 'getPaymentData', '', '', 'SUCCESS');

            if (($credentials['amount']) > 0) {
                $amount = str_replace(".", "", (number_format((float) $credentials['amount'], 2, '.', '')));
            } else {
                $amount = '00';
            }


            return response()->json([
                'responseStatus' => $responseStatus,
                'data' => new PaymentDetailResources($user->view_paymentDetail, $R1, $R2, $amount)
            ], 200);
        } else {
            $responseStatus = $this->formatJsonData('30001', 'getPaymentData', 'Data not found', 'Popup', 'ERROR');
            return response()->json(['responseStatus' => $responseStatus, 'data' => null], 400);
        }
    }
}