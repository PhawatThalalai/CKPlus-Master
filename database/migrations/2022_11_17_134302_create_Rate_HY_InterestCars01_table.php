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
        Schema::create('Rate_HY_InterestCars01', function (Blueprint $table) {
            $table->id();

            $table->string('Flag')->nullable();                         // Flag
            $table->string('Year_Start')->nullable();                   // ปีเรถริ่มต้น
            $table->string('Year_End')->nullable();                     // ปีรถสิ้นสุด
            $table->string('Installment')->nullable();                  // งวด
            $table->string('Interest')->nullable();                     // ดอกเบี้ย
            $table->string('Operation_Fee')->nullable();                // ค่าดำเนินการ
            $table->string('Percent_Rate1')->nullable();                // เปอร์เซ็น กรรมสิทธิ์ 1
            $table->string('Percent_Rate2')->nullable();                // เปอร์เซ็น กรรมสิทธิ์ 2
            $table->string('Percent_Rate3')->nullable();                // เปอร์เซ็น รีไฟแนนซ์ 1
            $table->string('Percent_Rate4')->nullable();                // เปอร์เซ็น ซื้อขาย 1
            $table->string('Percent_Rate5')->nullable();                // เปอร์เซ็น ซื้อขาย 2
            $table->string('Percent_Rate6')->nullable();                // เปอร์เซ็น ซื้อขาย 3
            $table->string('Type_Leasing')->nullable();                 // ประเภทสัญญา
            $table->string('Commission')->nullable();                   // คอมมิชชั่น
            $table->string('Vat')->nullable();                          // Vat
            $table->string('Credo_Score')->nullable();                  // Credo_Score
            $table->string('Percent_Credo')->nullable();                // เปอร์เซ็น Credo
            $table->string('Percent_Credo_Refi')->nullable();           // เปอร์เซ็น Credo รีไฟแนนซ์
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Rate_HY_InterestCars01');
    }
};
