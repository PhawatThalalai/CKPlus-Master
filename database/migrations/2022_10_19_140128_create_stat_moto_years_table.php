<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatMotoYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Stat_MotoYear', function (Blueprint $table) {
            $table->id();
            $table->integer('Brand_id')->nullable();   //id ยี่ห้อรถ
            $table->integer('Group_id')->nullable();   // id กลุ่มรถ
            $table->integer('Model_id')->nullable();   // id รุ่นรถ
            $table->string('Ratetype_id')->nullable(); // code ประเภทรถ
            $table->string('Year_moto')->nullable();     // ปี
            $table->string('PriceAT_moto')->nullable();  // ราคา
            $table->string('PriceMT_moto')->nullable();     // ราคาที่ใช้
            $table->string('Status_year')->nullable();  // เปิดปิด yes no

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
        Schema::dropIfExists('Stat_MotoYear');
    }
}
