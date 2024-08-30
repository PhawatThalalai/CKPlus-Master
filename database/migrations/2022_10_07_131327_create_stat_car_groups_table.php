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
        Schema::create('Stat_CarGroup', function (Blueprint $table) {
            $table->id();
            $table->integer('Brand_id')->nullable();      //id ยี่ห้อรถ
            $table->string('Ratetype_id')->nullable();    // code ประเภทรถ
            $table->string('Group_car')->nullable();      // ชื่อกลุ่มรถ
            $table->string('Status_group')->nullable();   // เปิดปิด yes no

            $table->integer('UserZone')->nullable();
            $table->string('UserBranch')->nullable();
            $table->string('UserInsert')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Stat_CarGroup');
    }
};
