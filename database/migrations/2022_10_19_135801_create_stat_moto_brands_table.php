<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatMotoBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Stat_MotoBrand', function (Blueprint $table) {
            $table->id();
            $table->string('Brand_moto')->nullable();               //ยี่ห้อรถ
       
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
        Schema::dropIfExists('Stat_MotoBrand');
    }
}
