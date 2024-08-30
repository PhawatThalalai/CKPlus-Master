<?php

namespace App\Models\TB_Logs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TB_DataCus\Data_CusTags;
use App\Models\TB_DataCus\Data_Customers;

class Data_CredoCodes extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'Data_CredoCodes';
    protected $fillable = [
        'data_customer_id',
        'data_tag_id',
        'statusActive',
        'tel_cus',
        'credo_flag',
        'credo_date',
        'credo_status',
        'credo_code',
        'credo_score',
        'credo_score2',
        'credo_score_detail',
        'device_id',
        'device_name',
        'platform',
    ];

    public function credoCustomer()
    {
        return $this->belongsTo(Data_Customers::class, 'data_customer_id', 'id');
    }

    public function credoCustag()
    {
        return $this->belongsTo(Data_CusTags::class, 'credo_code', 'Credo_Code');
    }
}
