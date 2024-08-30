<?php

namespace App\Models\TB_permission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class modules extends Model
{
    use HasFactory;
    protected $table = 'modules';
    protected $fillable = ['action','order','name_en','name_th'];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'module_id', 'id');
    }
}
