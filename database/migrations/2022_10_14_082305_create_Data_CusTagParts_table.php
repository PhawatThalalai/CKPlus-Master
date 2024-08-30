<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataCusTagPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Data_CusTagParts', function (Blueprint $table) {
            $table->id();
            $table->integer('DataCus_id')->nullable();
            $table->integer('DataTag_id')->nullable();
            $table->date('date_TrackPart')->nullable();                           
            $table->string('Code_TrackPart')->nullable();               //รหัส
            $table->string('Flag_TrackPart')->nullable();               
            $table->integer('Ordinal_TrackPart')->nullable();           //ลำดับ
            $table->string('Status_TrackPart')->nullable();             //สถานะ
            
            $table->date('Duedate_TrackPart')->nullable();              //วันนัดหมาย       
            $table->string('Userfollow_TrackPart')->nullable();         //ผู้ติดตาม       
            $table->string('StatusCancel_TrackPart')->nullable();       //สถานะยกเลิก       
            $table->string('Detail_TrackPart',"MAX")->nullable();       //รายละเอียด       

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
        Schema::dropIfExists('Data_CusTagParts');
    }
}
