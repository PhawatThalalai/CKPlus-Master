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
        Schema::create('TB_LetterStatusGroup', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_Letter')->nullable();                        // เพิ่ม ธง
            $table->string('Code_Letter');                                           //  รหัสกลุ่ม
            $table->string('Name_Letter')->nullable();                               //  รายละเอียด
            $table->float('Cond_HoldStart')->default('0')->nullable();        //  ค้างจาก
            $table->float('Cond_HoldEnd')->default('0')->nullable();          //  ค้างถึง
            $table->float('Pay_Letter')->default('0')->nullable();             //  ค่าจดหมาย
            $table->integer('PAYFOR_CODE')->nullable();                       //  รหัสค่าใช้จ่าย
            $table->integer('Past_Due')->default('0')->nullable();            // เลยวันดิว X วัน
            $table->integer('Auto_Letter')->default('0')->nullable();       //  ตั้งลูกหนี้ค่าจดหมายอัติโนมัติ
            $table->string('Memo_Letter',"MAX")->nullable();                  //  บันทึก
            
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
        Schema::dropIfExists('TB_LetterStatusGroup');
    }
};
