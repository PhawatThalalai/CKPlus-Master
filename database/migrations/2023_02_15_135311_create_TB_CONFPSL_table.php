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
        Schema::create('TB_CONFPSL', function (Blueprint $table) {
            $table->id();
            $table->string('FLAG')->nullable();
            $table->string('LATEPER')->nullable();     // เบี้ยปรับล่าช้า     
            $table->string('INT')->nullable();         // ดอกเบี้ย
            $table->string('LATENFINE')->nullable();   // จำนวนวันล่าช้าไม่มีเบี้ยปรับ
            $table->string('DATESEND')->nullable();    // รับจดหมายภายในกี่วัน
            $table->string('OPRFEE')->nullable();      // ค่าดำเนินการ
            $table->string('MAXINT')->nullable();      // อัตราดอกเบี้ยสูงสุด
            $table->string('FEE')->nullable();         // ค่าธรรมเนียมใช้วงเงินกู้
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
        Schema::dropIfExists('TB_CONFPSL');
    }
};
