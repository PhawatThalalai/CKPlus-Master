<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePactContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Pact_Contracts', function (Blueprint $table) {
            $table->id();
            $table->integer('DataCus_id')->nullable();
            $table->integer('DataTag_id')->nullable();             

            $table->string('FlagActices_Con')->nullable();              //สถานะ active ทำงาน
            $table->string('NameActices_Con')->nullable();              //ชื่อ

            $table->string('CodeLoan_Con')->nullable();                 //ประเภทสัญญา
            $table->string('Contract_Con')->nullable();                 //เลขที่สัญญา
            $table->string('Status_Con')->nullable();                   //สถานะสัญญา
            $table->string('UserSent_Con')->nullable();                 //ผู้ส่งจัด
            $table->string('BranchSent_Con')->nullable();               //สาขา
            $table->date('Date_Con')->nullable();                       //วันที่ขอทำสัญญา

            $table->string('UserApp_Con')->nullable();                  //สิทธิ์ผู้อนุมัติ
            $table->string('StatusApp_Con')->nullable();                //สถานะ อนุมัติ / รออนุมัติ

            $table->string('UserCancel_Con')->nullable();               //ผู้ยกเลิกสัญญา
            $table->date('DateCancel_Con')->nullable();                 //วันที่ยกเลิกสัญญา

            $table->string('DocApp_Con')->nullable();                   //ผู้ขออนุมัติ
            $table->date('DateDocApp_Con')->nullable();                 //วันที่
            $table->string('ConfirmDocApp_Con')->nullable();            //ผู้อนุมัติ
            $table->date('DateConfirmDocApp_Con')->nullable();          //วันที่        
            $table->string('AuditDoc_Con')->nullable();                 //ผู้ตรวจสอบ
            $table->date('DateAuditDoc_Con')->nullable();               //วันที่
            $table->string('ConfirmApp_Con')->nullable();               //สัญญาสมบูรณ์
            $table->date('DateConfirmApp_Con')->nullable();             //วันที่
            $table->string('Checkers_Con')->nullable();                 //Checkers 
            $table->date('Date_Checkers')->nullable();                  //dateCheckers

            $table->string('Check_Bookcar')->nullable();                //เช็คเล่มทะเบียน 
            $table->date('DateCheck_Bookcar')->nullable();              //วันที่     
            $table->string('LinkBookcar', "MAX")->nullable();           //ลิ้งอัพโหลด  เช็คเล่ม     
            $table->string('Special_Bookcar')->nullable();              //ขออนุมัติพิเศษ
            $table->date('DateSpecial_Bookcar')->nullable();            //วันที่
            $table->string('BookSpecial_Trans')->nullable();            //ได้รับเล่มทะเบียน 
            $table->date('Date_BookSpecial')->nullable();               //วันที่
            $table->string('LinkBookSpecial', "MAX")->nullable();       //ลิ้งอัพโหลด  ได้รับเล่มทะเบียน      
            $table->string('Email_Con')->nullable();                    //อีเมลล์
            $table->string('Msteams_Id')->nullable();                   //Id MS Teams
            $table->string('LinkUpload_Con', "MAX")->nullable();        //ลิ้งอัพโหลด

            $table->date('DateDue_Con')->nullable();                    //วันชำระงวดแรก
            $table->string('Approve_monetary')->nullable();             //การเงินโอนเงิน
            $table->date('Date_monetary')->nullable();                  //วันที่
            $table->string('FlagSpecial_Trans')->nullable();            //สถานะโอนปิดพิเศษ
            $table->date('Date_FlagSpecial')->nullable();               //วันที่

            $table->string('Commission_Trans')->nullable();            //userโอนค่าคอม
            $table->date('Date_Commission')->nullable();               //วันที่

            $table->date('Bank_Close')->nullable();                    // ธนาคารที่ปิดบัญชี
            $table->date('Bank_Out')->nullable();                      // ธนาคารที่โอนลูกค้า
            $table->date('Bank_Out_Com')->nullable();                  // ธนาคารที่โอนค่าคอม
            $table->date('Cus_Ref')->nullable();                       // ผู้อ้างอิง
            $table->date('PhoneCus_Ref')->nullable();                  // เบอร์โทร ผู้อ้างอิง
            $table->date('Data_Reg')->nullable();                      // Data_Reg
            $table->date('Data_UnReg')->nullable();                    // Data_UnReg
            $table->date('Data_Purpose')->nullable();                  // Data_Purpose

            $table->string('Memo_Objective', "MAX")->nullable();        //วัตถุประสงค์สินเชื่อ
            $table->string('Memo_Con', "MAX")->nullable();              //หมายเหตุ

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
        Schema::dropIfExists('Pact_Contracts');
    }
}
