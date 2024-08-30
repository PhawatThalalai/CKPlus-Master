<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataRateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_rateTypes', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_car')->nullable();         //สถานะ
            $table->string('type_car')->nullable();         //ประเภทรถ
            $table->string('code_car')->nullable();         //code
            $table->string('nametype_car')->nullable();     //ชื่อประเภทรถ
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
        Schema::dropIfExists('data_rateTypes');
    }
}
