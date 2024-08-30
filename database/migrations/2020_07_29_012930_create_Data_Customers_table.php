<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Data_Customers', function (Blueprint $table) {
            $table->id();
            $table->date('date_Cus')->nullable();
            $table->string('Code_Cus')->nullable();                         //รหัสลูกค้า
            $table->string('Status_Cus')->nullable();                       //สถานะลูกค้า
            $table->string('type_Cus')->nullable();
            $table->string('Prefix')->nullable();
            $table->string('PrefixOther')->nullable();
            $table->string('Name_Cus')->nullable();
            $table->string('Firstname_Cus')->nullable();                    // ชื่อจริง
            $table->string('Surname_Cus')->nullable();
            $table->string('Nickname_cus')->nullable();
            $table->string('NameEng_cus')->nullable();
            $table->string('Type_Card')->nullable();                        //ประเภทบัตรประจำตัว
            $table->string('IDCard_cus')->nullable();
            $table->date('IdcardExpire_cus')->nullable();                   //วันหมดอายุบัตร ปชช
            $table->date('Birthday_cus')->nullable();                       //วันเดือนปีเกิด
            $table->string('Gender_cus')->nullable();                        //เพศ
            $table->string('Phone_cus')->nullable();                        //เบอร์โทร
            $table->string('Marital_cus')->nullable();                      //สถานะสมรส
            $table->string('Nationality_cus')->nullable();                  //สัญชาติ
            $table->string('Religion_cus')->nullable();                     //ศาสนา
            $table->string('Mate_cus')->nullable();                         //คู่สมรส
            $table->string('Mate_Phone')->nullable();                       //เบอร์ดทรคู่สมรส
            $table->string('Reference')->nullable();                        //ผู้อ้างอิง
            $table->string('Driver_cus')->nullable();                       //ใบขับขี่
            $table->string('Namechange_cus')->nullable();                   //ประวัติเปลี่ยนชื่อ
            $table->string('Social_Line')->nullable();                      //Line
            $table->string('Social_facebook')->nullable();                  //facebook
            $table->string('image_cus', "MAX")->nullable();                 //รูป
            $table->string('Name_Account')->nullable();                     //ชื่อธนาคาร
            $table->string('Branch_Account')->nullable();                   //สาขา
            $table->string('Number_Account')->nullable();                   //เลขบัญชี
            $table->string('Note_cus', "MAX")->nullable();
            $table->integer('UserZone')->nullable();
            $table->string('UserBranch')->nullable();
            $table->string('UserInsert')->nullable();
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
        Schema::dropIfExists('Data_Customers');
    }
}
