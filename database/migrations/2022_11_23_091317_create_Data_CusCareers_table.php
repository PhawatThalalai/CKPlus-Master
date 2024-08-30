<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Data_CusCareers', function (Blueprint $table) {
            $table->id();
            $table->integer('DataCus_id')->nullable();
            $table->date('date_Cus')->nullable();

            $table->string('Code_Cus')->nullable();                         //รหัส
            $table->integer('Ordinal_Cus')->nullable();                     //ลำดับ
            $table->string('Status_Cus')->nullable();                       //สถานะ

            $table->string('Career_Cus')->nullable();                       //อาชีพ
            $table->string('DetailCareer_Cus')->nullable();                 //รายละเอียดอาชีพ
            $table->string('Workplace_Cus')->nullable();                    //สถานที่ทำงาน
            $table->integer('Income_Cus')->nullable();                      //รายได้
            $table->integer('BeforeIncome_Cus')->nullable();                //หักค่าใช้จ่าย
            $table->integer('AfterIncome_Cus')->nullable();                 //คงเหลือหลังหัก
            $table->string('IncomeNote_Cus', "MAX")->nullable();            //หมายเหตุรายได้

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
        Schema::dropIfExists('Data_CusCareers');
    }
};
