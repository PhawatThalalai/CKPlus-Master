<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataCusTagCalculatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Data_CusTagCalculates', function (Blueprint $table) {
            $table->id();
            $table->integer('DataCus_id')->nullable();
            $table->integer('DataTag_id')->nullable();
            $table->date('Date_Calcu')->nullable();

            $table->string('TypeLoans')->nullable();                        //ประเภทสัญญา car or moto
            $table->string('CodeLoans')->nullable();                        //รหัสสัญญา
            
            $table->string('RateCartypes')->nullable();                     //ประเภทรถ
            $table->string('RateBrands')->nullable();                       //ยี่ห้อรถ
            $table->string('RateGroups')->nullable();                       //กลุ่มรถ
            $table->string('RateModals')->nullable();                       //รุ่นรถ
            $table->string('RateYears')->nullable();                        //ปีรถ
            $table->string('RateGears')->nullable();                        //เกียร์รถ
            $table->integer('RatePrices')->nullable();                      //ราคางกลางรถ

            $table->string('TypeAssetsPoss')->nullable();                   //สถานะครอบครอง
            $table->string('DateOccupiedcar')->nullable();                  //วันที่ครอบครอง
            $table->string('NumDateOccupiedcar')->nullable();               //จำนวนวันครอบครอง

            $table->string('DateInArea')->nullable();                       //วันที่อยู่ในพื้นที่
            $table->string('NumDateInArea')->nullable();                    //จำนวนวันที่อยู่ในพื้นที่
            
            $table->string('Cus_grade')->nullable();                        //เกรดลูกค้า
            $table->string('Payment_Due')->nullable();                      //จำนวนงวดผ่อน
            $table->string('Payment_Status')->nullable();                   //สถานะการจ่าย (เช่าซื้อ)    
            $table->integer('RatePrice_Car')->default('0')->nullable();     //เรทยอดจัดจากการคำนวณ
            $table->integer('TotalLand_Rate')->default('0')->nullable();     //ยอดติดต่อที่ดิน
            
            $table->string('Promotions')->nullable();                       //Promotions
            $table->integer('Cash_Car')->default('0')->nullable();          //ยอดจัด
            $table->float('Process_Car')->default('0')->nullable();         //ค่าดำเนินการ
            $table->string('StatusProcess_Car')->nullable();                //สถานะ ค่าดำเนินการ
            $table->float('Insurance')->default('0')->nullable();           //ค่าประกัน รถ 
            $table->float('Insurance_PA')->default('0')->nullable();        //ค่าประกัน บุคคล 
            $table->float('Percent_Car')->nullable();                       //% จัดไฟแนนซ์
            $table->integer('Timelack_Car')->nullable();                    //ระยะเวลาผ่อน
            $table->float('Interest_Car')->nullable();                      //ดอกเบี้ย
            $table->float('Interestmore_Car')->nullable();                  //ดอกเบี้ยพิเศษ
            $table->string('Flag_Interest')->nullable();                    //สถานะดอกเบี้ย
            $table->float('totalInterest_Car')->default('0')->nullable();   //รวมดอกเบี้ย
            $table->float('InterestYear_Car')->default('0')->nullable();    //ดอกเบี้ยรายปี

            $table->float('Vat_Rate')->nullable();                          //Vat
            $table->float('Period_Rate')->default('0')->nullable();         //ชำระต่องวด
            $table->float('Tax_Rate')->default('0')->nullable();            //ภาษี
            $table->float('Tax2_Rate')->default('0')->nullable();           //ระยะผ่อน-1
            $table->float('Duerate_Rate')->default('0')->nullable();        //ค่างวด
            $table->float('Duerate2_Rate')->default('0')->nullable();       //ระยะผ่อน-2
            $table->float('Profit_Rate')->default('0')->nullable();         //กำไรจากยอดจัด
            $table->float('TotalPeriod_Rate')->default('0')->nullable();    //ยอดชำระทั้งหมด

            $table->float('Rate_ownership1')->default('0')->nullable();     // เรทกรรมสิทธิ์-1     
            $table->float('Rate_ownership2')->default('0')->nullable();     // เรทกรรมสิทธิ์-2      
            $table->float('Rate_ownership3')->default('0')->nullable();     // เรทกรรมสิทธิ์-3    
            $table->float('Rate_ownership4')->default('0')->nullable();     // เรทกรรมสิทธิ์-4
            $table->float('Rate_ownership5')->default('0')->nullable();     // เรทกรรมสิทธิ์-5
            $table->float('Rate_trade1')->default('0')->nullable();         // เรทซื้อขาย-1
            $table->float('Rate_trade2')->default('0')->nullable();         // เรทซื้อขาย-2
            $table->float('Rate_trade3')->default('0')->nullable();         // เรทซื้อขาย-3
            $table->float('Commission')->default('0')->nullable();          //ค่าคอมมิชชั่น 
            $table->string('Note_Cal')->nullable();                         //แจ้งเตือนเรทยอดจัด  
            $table->string('Note_Credo')->nullable();                         //remark cal credo
            $table->string('Prices_balance')->nullable();                   //ยอดค้างเดิม  
            $table->string('Result_rate')->nullable();                      //ยอดที่สามารถจัดได้สูงสุด ( ไมโคร )  

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
        Schema::dropIfExists('Data_CusTagCalculates');
    }
}
