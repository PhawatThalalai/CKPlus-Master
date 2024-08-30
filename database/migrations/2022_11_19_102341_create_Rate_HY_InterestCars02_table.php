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
        Schema::create('Rate_HY_InterestCars02', function (Blueprint $table) {
            $table->id();
            $table->string('Flag')->nullable();                   // Flag
            $table->string('Year_Start')->nullable();             // ปีเรถริ่มต้น
            $table->string('Year_End')->nullable();               // ปีรถสิ้นสุด
            $table->string('Installment')->nullable();            // งวด
            $table->string('Interest')->nullable();               // ดอกเบี้ย
            $table->string('Operation_Fee')->nullable();          // ค่าดำเนินการ
            $table->string('Percent_Rate1')->nullable();          // เรท 30-59
            $table->string('Percent_Rate2')->nullable();          // เรท 60-89
            $table->string('Percent_Rate3')->nullable();          // เรทรีไฟแนนซ์จากที่อื่น
            $table->string('Percent_Rate4')->nullable();          // เรท 1-30
            $table->string('Percent_Rate5')->nullable();          // เรท มากกว่า 90 วัน
            $table->string('Percent_Rate6')->nullable();          // เรทรีไฟแนนซ์จากชูเกียรติ

            $table->string('Type_Leasing')->nullable();           // เลขประเภทสัญญา
            $table->string('Commission')->nullable();             // คอมมิชชั่น
            $table->string('Vat')->nullable();                    // Vat
            $table->string('Credo_Score')->nullable();            // Credo_Score
            $table->string('Percent_Credo1')->nullable();         // เปอร์เซ็น Credo เรท 60-89
            $table->string('Percent_Credo2')->nullable();         // เปอร์เซ็น Credo เรท มากกว่า 90 วัน
            $table->string('Percent_Credo_Refi')->nullable();     // เปอร์เซ็น Credo รีไฟแนนซ์
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
        Schema::dropIfExists('Rate_HY_InterestCars02');
    }
};
