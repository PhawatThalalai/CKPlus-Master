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
        Schema::create('Pact_Operatedfees', function (Blueprint $table) {
            $table->id();
            $table->integer('DataTag_id')->nullable();
            $table->integer('PactCon_id')->nullable();

            $table->integer('Payee_id')->nullable();                                      //ผู้รับเงิน
            $table->integer('Broker_id')->nullable();                                     //ผู้แนะนำ
            $table->string('FalgCom_Broker')->nullable();
            $table->string('Commission_Broker')->default('0')->nullable();              //ค่าคอมนายหน้า
            $table->float('SumCom_Broker')->default('0')->nullable();                   //รวมค่าคอมนายหน้า

            $table->float('AccountClose_Price')->default('0')->nullable();              //ยอดปิดบัญชี 
            $table->float('AccountClose_Price_fee')->default('0')->nullable();          //ค่าปิดบัญชี 
            $table->float('P2_Price')->default('0')->nullable();                        //ซื้อ ป2+/ป1
            $table->float('Insurance_PA')->default('0')->nullable();                    //ซื้อ ป2+/ป1
            $table->float('Act_Price')->default('0')->nullable();                       //พรบ.
            $table->float('Tax_Price')->default('0')->nullable();                       //ภาษี

            $table->float('Tran_Price')->default('0')->nullable();                      //ค่าใช้จ่ายขนส่ง
            $table->float('Other_Price')->default('0')->nullable();                     //อื่นๆ
            $table->float('Evaluetion_Price')->default('0')->nullable();                //ค่าประเมิน
            $table->float('Duty_Price')->default('0')->nullable();                      //อากร
            $table->float('Marketing_Price')->default('0')->nullable();                 //ค่าการตลาด

            $table->float('DuePrepaid_Price')->default('0')->nullable();                //ค่างวดล่วงหน้า
            $table->float('Process_Price')->default('0')->nullable();                   //ค่าดำเนินการ
            
            $table->float('Total_Price')->default('0')->nullable();                     //รวม คชจ.
            $table->float('Balance_Price')->default('0')->nullable();                   //คงเหลือ

            $table->string('Installment')->nullable();                                  //การผ่อน
            $table->string('Note_fee', "MAX")->nullable();                              //หมายเหตุ
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
        Schema::dropIfExists('Pact_Operatedfees');
    }
};
