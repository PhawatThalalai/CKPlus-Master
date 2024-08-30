<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataCusAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Data_CusAddress', function (Blueprint $table) {
            $table->id();
            $table->integer('DataCus_id')->nullable();
            $table->date('date_Adds')->nullable();                           
            $table->string('Code_Adds')->nullable();               //รหัส
            $table->integer('Ordinal_Adds')->nullable();           //ลำดับ
            $table->string('Status_Adds')->nullable();             //สถานะ

            $table->string('Type_Adds')->nullable();               //ประเภทที่อยู่
            $table->string('houseNumber_Adds')->nullable();        //บ้านเลขที
            $table->string('houseGroup_Adds')->nullable();         //หมู่
            $table->string('building_Adds')->nullable();           //อาคาร
            $table->string('village_Adds')->nullable();            //หมู่บ้าน
            $table->string('roomNumber_Adds')->nullable();         //ห้อง
            $table->string('Floor_Adds')->nullable();              //ชั้นที่
            $table->string('alley_Adds')->nullable();              //ซอย
            $table->string('road_Adds')->nullable();               //ถนน

            $table->string('houseZone_Adds')->nullable();          //ภูมิภาค
            $table->string('houseProvince_Adds')->nullable();      //จังหวัด
            $table->string('houseDistrict_Adds')->nullable();      //อำเภอ
            $table->string('houseTambon_Adds')->nullable();        //ตำบล
            $table->string('Postal_Adds')->nullable();             //เลขไปรษณีย์
            $table->string('Detail_Adds',"MAX")->nullable();       //รายละเอียดที่อยู่
            $table->string('Coordinates_Adds',"MAX")->nullable();  //พิกัด

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
        Schema::dropIfExists('Data_CusAddress');
    }
}
