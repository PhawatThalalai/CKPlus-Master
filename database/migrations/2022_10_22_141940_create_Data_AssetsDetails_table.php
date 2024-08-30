<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataAssetsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Data_AssetsDetails', function (Blueprint $table) {
            $table->id();

            $table->string('FlagEdit_AssetDetails')->nullable();    // ธงแก้ไข
            $table->integer('DataAsset_Id')->nullable();            // ไอดี DataAsset ที่เชื่อมอยู่

            $table->string('OccupiedDT');               // วันครอบครองล่าสุด
            $table->string('OccupiedTime', 150);             // ระยะเวลาครอบครอง

            // ข้อมูลการประกัน -----------------------
            $table->string('InsuranceType_Code')->nullable();        // ประกันภัย (ข้อมูลเดิม) *เลิกใช้แล้ว*

            $table->string('InsuranceState')->nullable();               // สถานประกัน (ซื้อ,มี,ไม่มี)
            $table->string('InsuranceClass')->nullable();                // ป1 ป2 ป3 ป2+ ป3+

            $table->string('PolicyNumber', 100)->nullable();             // เลขกรมธรรม์
            $table->string('InsuranceDT')->nullable();              // คุ้มครองประกัน
            $table->string('InsuranceActDT')->nullable();           // คุ้มครอง พรบ
            $table->string('InsuranceRegisterDT')->nullable();      // คุ้มครองทะเบียน
            $table->string('PurposeType', 150)->nullable();          // รูปแบบรถยนต์ (จุดประสงค์การใช้รถ)
            $table->string('PossessionState_Code')->nullable();          // สถานะครอบครอง
            $table->string('PossessionOrder', 150)->nullable();          // ลำดับครอบครอง
            $table->string('History_16', 150)->nullable();               // ประวัติหน้า 16.
            $table->string('History_18', 150)->nullable();               // ประวัติหน้า 18.

            // MilesNumber
            $table->string('MilesNumber', 50)->nullable()->comment('เลขไมล์ ใน Details');

            $table->decimal('MidPrice', 18, 2)->nullable()->comment('ราคากลาง Details');
            $table->date('OccupiedDate')->nullable()->comment('วันครอบครองแบบวันที่');

            //------------------ ข้อมูลผู้บันทึก -------------------
            $table->integer('UserZone')->nullable();
            $table->string('UserBranch')->nullable();
            $table->string('UserInsert')->nullable();

            $table->timestamps();
            $table->softDeletes(); // This adds the 'deleted_at' column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Data_AssetsDetails');
    }
}
