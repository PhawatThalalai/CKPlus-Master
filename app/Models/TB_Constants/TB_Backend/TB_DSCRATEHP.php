<?php

namespace App\Models\TB_Constants\TB_Backend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// ! เหลือ Migrations ยังไม่เสร็จ

class TB_DSCRATEHP extends Model
{
    use SoftDeletes;

    protected $table = 'TB_DSCRATEHP';
    protected $fillable = [
        'id',
        'PERD84',
        'PERD78',
        'PERD72',
        'PERD66',
        'PERD60',
        'PERD54',
        'PERD48',
        'PERD42',
        'PERD36',
        'PERD30',
        'PERD24',
        'PERD18',
        'PERD12'
    ];

    public function getTableInfo() {
        // ชื่อของตารางที่ต้องการดึงข้อมูล
        $tableName = $this->getTable();

        // ใช้คอลัมน์ที่ fillable
        $columns = $this->fillable;

        // ดึงข้อมูลทั้งหมดจากตาราง
        $rows = $this->all($columns);

        return compact('columns', 'rows', 'tableName');
    }

}
