<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataRatemotosKbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_ratemotos_kb', function (Blueprint $table) {
            $table->integer('id');
            $table->primary('id');
            $table->string('ratetype_id')->nullable();       //key Cartype
            $table->string('brand_moto')->nullable();        //ยี่ห้อรถ
            $table->string('model_moto')->nullable();        //รุ่นรถ
            $table->string('group_moto')->nullable();        //กลุ่มรถ
            $table->string('year_moto')->nullable();         //ปีรถ
            $table->string('Estimate_moto')->nullable();     //ราคากลาง
            $table->string('price_moto')->nullable();        //ยอดปล่อย
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
        Schema::dropIfExists('data_ratemotos_kb');
    }
}
