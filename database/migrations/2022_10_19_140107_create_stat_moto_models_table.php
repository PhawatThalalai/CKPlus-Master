<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatMotoModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Stat_MotoModel', function (Blueprint $table) {
            $table->id();
            $table->integer('Brand_id')->nullable();   //id ยี่ห้อรถ
            $table->integer('Group_id')->nullable();   // id กลุ่มรถ
            $table->string('Ratetype_id')->nullable(); // code ประเภทรถ
            $table->string('Model_moto')->nullable();   // ชื่อ รุ่นรถ
            $table->string('Status_model')->nullable();  // เปิดปิด yes no

            $table->integer('UserZone')->nullable();
            $table->string('UserBranch')->nullable();
            $table->string('UserInsert')->nullable();
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
        Schema::dropIfExists('Stat_MotoModel');
    }
}
