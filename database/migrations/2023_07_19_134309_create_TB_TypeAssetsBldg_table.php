<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_TypeAssetsBldg', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_TypeBldg');                    // ธง สถานะ
            $table->string('Code_TypeBldg');                    // รหัสประเภท
            $table->string('Name_TypeBldg');                    // ชื่อประเภท
            $table->string('No_Building')->nullable();          // ไม่มีสิ่งปลูกสร้าง

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TB_TypeAssetsBldg');
    }
};
