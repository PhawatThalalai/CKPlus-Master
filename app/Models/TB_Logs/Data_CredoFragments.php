<?php

namespace App\Models\TB_Logs;

use Illuminate\Database\Eloquent\Model;

class Data_CredoFragments extends Model
{
    protected $table = 'Data_CredoFragments';
    protected $fillable = ['referenceNumber' ,'uploadDate' ,'scores'    ,'device_id'
                            ,'fragments1' ,'fragments2' ,'fragments3' ,'fragments4' ,'fragments5'    ,'fragments6'
                            ,'fragments7'  ,'fragments8'  ,'fragments9' ,'fragments10'];
}
