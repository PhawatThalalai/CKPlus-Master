<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataCusTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Data_CusTags', function (Blueprint $table) {
            $table->id();
            $table->integer('DataCus_id')->nullable();
            $table->date('date_Tag')->nullable();                           
            $table->string('Code_Tag')->nullable();                     //รหัส
            $table->integer('Ordinal_Tag')->nullable();                 //ลำดับ
            $table->string('Status_Tag')->nullable();                   //สถานะ

            $table->string('Type_Customer')->nullable();                //ประเภทลูกค้า
            $table->string('Resource_Customer')->nullable();            //แหล่งที่มา
            $table->string('Credo_Code')->nullable();
            $table->string('Credo_Score')->nullable();
            $table->string('Credo_Status')->nullable();
            $table->dateTime('Credo_Date')->nullable();

            $table->integer('successor')->nullable();                   //ผู้สืบทอด
            $table->dateTime('successor_date')->nullable();            //วันที่สืบทอด
            $table->string('successor_status')->nullable();            //สถานะ

            $table->string('Note_Tag',"MAX")->nullable();              //หมายเหตุ
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
        Schema::dropIfExists('Data_CusTags');
    }
}
