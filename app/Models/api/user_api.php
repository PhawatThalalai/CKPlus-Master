<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

use App\Models\TB_DataCus\Data_Customers;
use App\Models\api\view\view_leasingAccounts;
use App\Models\api\view\view_Invoices;
use App\Models\api\view\view_Receipts;
use App\Models\api\view\view_Payments;

class user_api extends Model
{
    use HasApiTokens, HasFactory;
//protected $connection = 'sqlsrv2';
    protected $table = 'user_api';
    protected $fillable = ['data_customer_id', 'token', 'device_name', 'platform', 'platform_version', 'app_version', 'app_version_code', 'device_id'];

    public function dataCustomer()
    {
        return $this->belongsTo(Data_Customers::class, 'data_customer_id');
    }

    public function view_leasingAcct()
    {
        return $this->hasMany(view_leasingAccounts::class, 'datacus_id', 'data_customer_id');
    }

    public function view_invoice()
    {
        return $this->hasMany(view_Invoices::class, 'customerId', 'data_customer_id');
    }
    public function view_invoiceDetail()
    {
        return $this->hasOne(view_Invoices::class, 'customerId', 'data_customer_id');
    }

    public function view_receipt()
    {
        return $this->hasMany(view_Receipts::class, 'customerId', 'data_customer_id');
    }

    public function view_receiptDetail()
    {
        return $this->hasOne(view_Receipts::class, 'customerId', 'data_customer_id');
    }

    public function view_paymentDetail()
    {
        return $this->hasOne(view_Payments::class, 'customerId', 'data_customer_id');
    }
}
