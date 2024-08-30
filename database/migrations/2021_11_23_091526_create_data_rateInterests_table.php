<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataRateInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_rateInterests', function (Blueprint $table) {
            $table->integer('id');
            $table->primary('id');
            $table->string('ratetype_id')->nullable();       //key Cartype
            $table->string('year_rate')->nullable();        //ปี
            $table->string('instalment_rate')->nullable();  //จำนวนงวด
            $table->string('interest_rate')->nullable();    //ดอกเบี้ย
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
        Schema::dropIfExists('data_rateInterests');
    }
}
