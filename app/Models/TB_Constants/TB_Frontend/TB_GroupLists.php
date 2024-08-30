<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TB_Constants\TB_Frontend\TB_Groups;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;

class TB_GroupLists extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'TB_GroupLists';

    protected $fillable = [
        'Groups_id',
        'listStatus',
        'listDate',
        'listBranch_id',
    ];

    protected $dates = [
        'listDate',
    ];

    public function groups()
    {
        return $this->belongsTo(TB_Groups::class, 'Groups_id');
    }

    public function branchs()
    {
        return $this->belongsTo(TB_Branchs::class, 'listBranch_id');
    }
}
