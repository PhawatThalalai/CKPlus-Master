<?php

namespace App\Traits;

use App\Models\TB_Constants\TB_Frontend\TB_BankAccounts;
use Carbon\Carbon;

trait TreasDetectionLimits
{
    /**
     * Get users by roles
     *
     *
     * @param  string $CodeLoan_Con
     * @param  string $Date_BookSpecial
     * @param  string $FlagSpecial_Trans
     * @param  string $Code_Cus
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function checkCreditTransfer($back_id, $expenses)
    {
        $AmoutbankAccount = TB_BankAccounts::where('id', $back_id)
            ->where('User_Zone', auth()->user()->zone)
            ->first();

        if (!empty($AmoutbankAccount->BankToCredit)) {
            if (empty($AmoutbankAccount->BankToCredit->Amount_after) || $AmoutbankAccount->BankToCredit->Amount_after < ($expenses * (-1))) {
                return 'notEnough';
            } else {
                $totalBalance = $AmoutbankAccount->BankToCredit->Amount_after;
                $Bank_Zone = $AmoutbankAccount->User_Zone;

                return ['totalBalance' => $totalBalance, 'Bank_Zone' => $Bank_Zone];
            }
        } else {
            return null;
        }
    }

    public function checkPayee($CodeLoan_Con, $Date_BookSpecial, $FlagSpecial_Trans, $Code_Cus)
    {
        $arrLoan = ['01', '16', '18', '05', '07'];
        $FlagTransferFirst = null;
        $FlagTransferClose = null;
        $FlagTransfer = false;

        // CHECK CODE LOAN
        if (in_array($CodeLoan_Con, $arrLoan)) {
            if ($Date_BookSpecial != NULL) {
                $FlagTransferFirst = true;
            } else {
                $FlagTransferFirst = false;
            }
        } else {
            $FlagTransferFirst = true;
        }

        // CHECK TYRE CUSTOMER = 'รีไฟแนนท์(ปิดธนาคาร)' AND FLAG SPECIAL TRANSFER = 'ได้รับเล่มทะเบียน'
        if ($Code_Cus == 'CUS-0004' && ($FlagSpecial_Trans != NULL && $Date_BookSpecial != NULL)) {
            $FlagTransferClose = true;
        } else {
            if ($Code_Cus == 'CUS-0004') {
                $FlagTransferClose = false;
            } else {
                $FlagTransferClose = true;
            }
        }

        if ($FlagTransferFirst == true && $FlagTransferClose == true) {
            $FlagTransfer = true;
        } else {
            $FlagTransfer = false;
        }
        return $FlagTransfer;
    }

    public function checktransferPayee($pact) {
        $accountClose = $pact->ContractToOperated->AccountClose_Price ?? 0;

        $result = $pact->ContractToPayee->filter(function ($query) use ($accountClose) {
            return $query->status_Payee == 'CloseAcount' && $query->transferCash == $accountClose;
        });

        return $result->isNotEmpty() || !$pact->ContractToPayee->contains('status_Payee', 'CloseAcount');
    }


    public function checktransferBalance($pact) {
        $accountClose = $pact->ContractToOperated->AccountClose_Price ?? 0;
        $balancePrice = $pact->ContractToOperated->Balance_Price ?? 0;

        $result = $pact->ContractToPayee->map(function ($query) use ($accountClose, $balancePrice) {
            if ($query->status_Payee == 'CloseAcount' && $query->transferCash == $accountClose) {
                return true;
            } elseif ($query->status_Payee == 'Payee' && $query->transferCash == $balancePrice) {
                return true;
            }
            return false;
        });

        return !$result->contains(false);
    }

    public function generateDueDate($Loan)
    {
        $time = date("Y-m");
        $nextmonth = date('Y-m', strtotime($time . ' +1 month'));
        $nextTwomonth = date('Y-m', strtotime($time . ' +2 month'));

        $currentDay = intval(date('d'));
        switch (true) {
            case ($currentDay > 15 && $Loan != '16'):
                $duedate = $nextTwomonth . '-01';
                break;
            case ($currentDay > 10 ):
                $duedate = $nextmonth . '-15';
                break;
            case ($currentDay > 5):
                $duedate = $nextmonth . '-10';
                break;
            default:
                $duedate = $nextmonth . '-05';
                break;
        }

        return $duedate;
    }
}
