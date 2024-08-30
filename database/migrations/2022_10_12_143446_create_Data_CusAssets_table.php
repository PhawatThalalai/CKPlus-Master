<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataCusAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Data_CusAssets', function (Blueprint $table) {
            $table->id();
            $table->integer('DataCus_id')->nullable();
            $table->date('date_Asset')->nullable();

            $table->string('Code_Asset')->nullable();               //รหัส
            $table->integer('Ordinal_Asset')->nullable();           //ลำดับ
            $table->string('Status_Asset')->nullable();             //สถานะ

            $table->string('Type_Asset')->nullable();               //ประเภททรัพย์
            $table->string('Deednumber_Asset')->nullable();         //เลขที่โฉนด
            $table->string('Area_Asset')->nullable();               //เนื้อที
            
            $table->string('houseZone_Asset')->nullable();          //ภูมิภาค
            $table->string('houseProvince_Asset')->nullable();      //จังหวัด
            $table->string('houseDistrict_Asset')->nullable();      //อำเภอ
            $table->string('houseTambon_Asset')->nullable();        //ตำบล
            $table->string('Postal_Asset')->nullable();             //เลขไปรษณีย์
            $table->string('Coordinates_Asset')->nullable();        //พิกัด
            $table->string('Note_Asset',"MAX")->nullable();

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
        Schema::dropIfExists('Data_CusAssets');
    }
}
