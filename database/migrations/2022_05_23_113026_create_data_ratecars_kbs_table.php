<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataRatecarsKbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_ratecars_kb', function (Blueprint $table) {
            $table->integer('id');
            $table->primary('id');
            $table->string('ratetype_id')->nullable();       //key Cartype
            $table->string('brand_car')->nullable();        //ยี่ห้อรถ
            $table->string('group_car')->nullable();        //กลุ่มรถ
            $table->string('model_car')->nullable();        //รุ่นรถ
            $table->string('year_car')->nullable();         //ปีรถ
            $table->string('priceAT_car')->nullable();      //ราคา auto
            $table->string('priceMT_car')->nullable();      //ราคา ธรรมดา
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
        Schema::dropIfExists('data_ratecars_kb');
    }
}
