<?php

namespace App\Models\TB_Letter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use App\Models\User;
use App\Models\TB_Letter\Data_TKANGPAY;
use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\TB_view\View_CusConLetter;
use App\Models\TB_view\View_GuardConLetter;

class Data_PRINTLET extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;

    protected $table = 'Data_PRINTLET';
    protected $fillable =     
    [
        'LOCAT'
        ,'TKANGPAY_ID'
        ,'LETDOC'
        ,'DOCNO'
        ,'DOCDT'
        ,'CONTNO'
        ,'GCODE'
        ,'PRINTDT'
        ,'PRNNO'
        ,'USERID'
        ,'INPDATE'
        ,'POSTLT'
        ,'REPRINTDT'
        ,'REPRINTID'
        ,'LETTER'
        ,'userzone'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])->logOnlyDirty();
        // Chain fluent methods for configuration options
    }

    public function ToTKANGPAY()
    {
        return $this->belongsTo(Data_TKANGPAY::class,'CONTSTAT','CONTTYP');
    }

    public function ToPact()
    {
        return $this->belongsTo(Pact_Contracts::class, 'CONTNO', 'Contract_Con');
    }

    public function ToUser()
    {
        return $this->belongsTo(User::class, 'USERID', 'id');
    }

    public function View_CusConLetter()
    {
        return $this->hasOne(View_CusConLetter::class, 'CONTNO', 'CONTNO');
    }

    public function View_GuardConLetter()
    {
        return $this->hasOne(View_GuardConLetter::class, 'CONTNO', 'CONTNO');
    }
}
