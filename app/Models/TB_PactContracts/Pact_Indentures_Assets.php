<?php

namespace App\Models\TB_PactContracts;

use App\Models\TB_Assets\Data_AssetsOwnership;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

use App\Models\TB_Assets\Data_Assets;
use App\Models\TB_PactContracts\Pact_Contracts;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pact_Indentures_Assets extends Model
{
    use SoftDeletes;
    protected $table = 'Pact_Indentures_Assets';
    // Asset_id เป็น Ownership
    protected $fillable = ['DataTag_id', 'PactCon_id', 'Asset_id', 'StartCon_DT', 'UserZone', 'UserBranch', 'UserInsert'];

    //Asset_id = idOwn
    public function IndenAssetToContract()
    {
        return $this->belongsTo(Pact_Contracts::class, 'PactCon_id', 'id');
    }

    public function IndenAssetToDataOwner()
    {
        return $this->hasOne(Data_AssetsOwnership::class, 'id', 'Asset_id');
    }

    public function IndenAssetToAsset(): HasOneThrough
    {
        return $this->hasOneThrough(
            Data_Assets::class,
            Data_AssetsOwnership::class,
            'id', // Foreign key on the Pact_Con table...
            'id', // Foreign key on the Data_Cus table...
            'Asset_id', // Local key on the PatchTB_SPASTDUE table...
            'DataAsset_Id' // Local key on the Pact_Con table...
        );
    }

}

