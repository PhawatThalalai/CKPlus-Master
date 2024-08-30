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
        Schema::create('Stat_CarModel', function (Blueprint $table) {
            $table->id();
            $table->integer('Brand_id')->nullable();   //id ยี่ห้อรถยนต์
            $table->integer('Group_id')->nullable();   // id กลุ่มรถยนต์
            $table->string('Ratetype_id')->nullable(); // code ประเภทรถยนต์
            $table->string('Model_car')->nullable();   // ชื่อ รุ่นรถยนต์
            $table->string('Tank_No')->nullable();     // เลขถัง
            $table->string('Status_model')->nullable();  // เปิดปิด yes no

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
        Schema::dropIfExists('Stat_CarModel');
    }
};
