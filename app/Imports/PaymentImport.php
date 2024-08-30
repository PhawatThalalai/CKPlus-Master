<?php
namespace App\Imports;

use App\Models\TB_PatchContracts\TB_Payments\AutoPay\Data_AutoPayPsl;
use Maatwebsite\Excel\Concerns\ToModel;

class PaymentImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
 
        if(@$row[0]=="D"){
            $str=trim(@$row[6]);
           
        
            dd(iconv( 'TIS-620','UTF-8', @$row[6]));
         $data = new Data_AutoPayPsl ;
         $data->HEADER_ID =  trim(@$row[0]) ;
          $data->RECORD_TYPE = trim(@$row[0]);
          $data->SEQ_NO = trim(@$row[1]);
          $data->BANK_CODE = trim(@$row[2]);
          $data->COMPANY_ACCOUNT = trim(@$row[3]);
          $data->PAYMENT_DATE = trim(@$row[4]);
          $data->PAYMENT_TIME = trim(@$row[5]);
          $data->CUSTOMER_NAME = trim(iconv( 'UTF-8','TIS-620', @$row[6]));
          $data->REF1 = trim(@$row[7]);
          $data->REF2 = trim(@$row[8]);
          $data->REF3 = trim(@$row[9]);
          $data->BRANCH_NO = trim(@$row[10]);
          $data->TELLER_NO = trim(@$row[11]);
          $data->TRANSACTION_KIND = trim(@$row[12]);
          $data->TRANSACTION_CODE = trim(@$row[13]);
          $data->CHEQUE_NO = trim(@$row[14]);
          $data->AMOUNT = trim(@$row[15]);
          $data->CHEQUE_BANK_CODE = trim(@$row[16]);
          $data->POSTBL = trim(@$row[17]);
         $data->save();
         return $data;
        }
        
    }
    
}