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
        Schema::create('TMP_CANCONTRACTPSL', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('PatchCon_id')->nullable(); 
            $table->string('LOCAT',50)->nullable()->comment('สาขาของสัญญา');
            $table->string('CANNO',50)->nullable()->comment('เลขที่บอกเลิก');
            $table->string('CONTNO',15)->nullable()->comment('เลขที่สัญญา');
            $table->date('SDATE')->nullable()->comment('วันทำสัญญา');
            $table->decimal('TOTPRC',18,0)->nullable();
            $table->decimal('SMPAY',18,0)->nullable();
            $table->decimal('TOTBAL',18,0)->nullable();
            $table->decimal('EXP_AMT',18,0)->nullable();
            $table->date('CANDATE')->nullable()->comment('วันบอกเลิกสัญญา');
            $table->string('CANSTAT',50)->nullable()->comment('สาเหตุบอกเลิก');
            $table->integer('BILLCOLL')->nullable()->comment('ผู้ตาม');
            $table->integer('CHECKER')->nullable()->comment('ผู้ตรวจสอบ');
            $table->integer('USERCN')->nullable()->comment('ผู้ยกเลิก');
            $table->string('CONTSTAT',50)->nullable()->comment('สถานะสัญญา');
            $table->string('PAYFOR',50)->nullable()->comment('รหัสชำระ');
            $table->decimal('PAYAMT',18,0)->nullable();
            $table->string('MEMO1','MAX')->nullable()->comment('หมายเหตุ');
            $table->decimal('REXP_PRD',18,0)->nullable();
            $table->decimal('EXP_FRM',18,0)->nullable();
            $table->decimal('EXP_TO',18,0)->nullable();
            $table->decimal('KANGINT',18,0)->nullable();
            $table->decimal('TOTUPAY',18,0)->nullable();
            $table->date('PAYDATE')->nullable();
            $table->decimal('PAYMENT',18,0)->nullable();
            $table->decimal('KEXP_AMT',18,0)->nullable();
            $table->decimal('KEXP_PRD',18,0)->nullable();
            $table->date('LASTCANDT')->nullable();
            // $table->foreignId('PatchCon_id')->constrained('PatchPSL_Contracts')->index();
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
        Schema::dropIfExists('TMP_CANCONTRACTPSL');
        // Schema::table('TMP_CANCONTRACTPSL', function (Blueprint $table) {
        //     $table->dropIndex(['data_customer_id']);
        // });
    }
};
