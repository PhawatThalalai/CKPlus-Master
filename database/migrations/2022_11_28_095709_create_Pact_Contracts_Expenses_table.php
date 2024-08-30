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
        Schema::create('Pact__Contracts_Expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('SCHEMA_PN_Contracts_id')->nullable();
            $table->string('Name_Payee')->nullable();                                       //ผู้รับเงิน
            $table->string('IDCard_Payee')->nullable();                                     //เลขบัตร ผู้รับเงิน
            $table->string('NameAccount_Payee')->nullable();                                //ชื่อธนาคาร
            $table->string('Account_Payee')->nullable();                                    //เลขบัญชี
            $table->string('Phone_Payee')->nullable();                                      //เบอร์โทร

            $table->string('Name_Broker')->nullable();                                      //แนะนำ/นายหน้า
            $table->string('IDCard_Broker')->nullable();                                    //เลขบัตร ผู้รับเงิน
            $table->string('FlagCom_Broker')->nullable();                                   //สถานะ คิดค่าคอม
            $table->integer('Commission_Broker')->default('0')->nullable();                 //ค่าคอมนายหน้า

            $table->integer('closeAccount_Price')->default('0')->nullable();                //ยอดปิดบัญชี 
            $table->integer('otherClose_Price')->default('0')->nullable();                  //ค่าดำเนินการปิด
            $table->integer('P2_Price')->default('0')->nullable();                          //ซื้อ ป2+/ป1
            $table->integer('act_Price')->default('0')->nullable();                         //พรบ.
            $table->integer('Tax_Price')->default('0')->nullable();                         //ภาษี

            $table->integer('tran_Price')->default('0')->nullable();                        //ค่าใช้จ่ายขนส่ง
            $table->integer('other_Price')->default('0')->nullable();                       //อื่นๆ
            $table->integer('evaluetion_Price')->default('0')->nullable();                  //ค่าประเมิน
            $table->integer('duty_Price')->default('0')->nullable();                        //อากร
            $table->integer('marketing_Price')->default('0')->nullable();                   //ค่าการตลาด
            $table->integer('downpay_Price')->default('0')->nullable();                     //เงินดาวน์

            $table->integer('total_Price')->default('0')->nullable();                       //รวม คชจ.
            $table->integer('commit_Price')->default('0')->nullable();                      //ค่าคอมหลังหัก %
            $table->integer('balance_Price')->default('0')->nullable();                     //คงเหลือ
            $table->string('note_Price', "MAX")->nullable();                                //หมายเหตุ
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
        Schema::dropIfExists('Pact__Contracts_Expenses');
    }
};
