<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Data_Assets', function (Blueprint $table) {
            $table->id();

            $table->string('Flag_Asset')->nullable();           // ธงสถานะทรัพย์ ( NU = ยังไม่ผูก, CU = ผูกสัญญาแล้ว, SZ = ถูกยึดแล้ว)
            $table->string('Code_Asset');                       // รหัสทรัพย์
            $table->string('Status_Asset');                     // สถานะทรัพย์ (Active/Inactive)
            $table->string('TypeAsset_Code');                     // ไอดีประเภททรัพย์จากตาราง TB_TypeAssets (car/moto/land)
            //$table->integer('DataCus_Id');                       // ไอดีลูกค้าที่เป็นเจ้าของทรัพย์

            $table->integer('Price_Asset')->nullable();          // ราคากลาง/ราคาประเมิน

            //------------------ ข้อมูลรถยนต์/มอเตอร์ไซค์ -------------------
            $table->string('Vehicle_OldLicense')->nullable();
            $table->string('Vehicle_NewLicense')->nullable();
            $table->string('Vehicle_Chassis')->nullable();
            $table->string('Vehicle_Engine')->nullable();
            $table->string('Vehicle_Color')->nullable();
            $table->string('Vehicle_Miles')->nullable();
            $table->string('Vehicle_CC')->nullable();           // เลข CC
            $table->string('Vehicle_Type')->nullable();
            $table->string('Vehicle_Type_PLT')->nullable();     // ประเภทรถ ของ ธปท.

            $table->integer('Vehicle_Brand')->nullable();       // ไอดียี่ห้อรถ
            $table->integer('Vehicle_Group')->nullable();       // ไอดีกลุ่มรถ
            $table->integer('Vehicle_Model')->nullable();       // ไอดีรุ่นรถ
            $table->string('Vehicle_Year')->nullable();         // ปีรถ
            $table->string('Vehicle_Gear')->nullable();         // เกียร์รถ (ธรรมดา/ออโต้)

            //------------------ ข้อมูลที่ดิน -------------------
            $table->string('Land_Type')->nullable();            // ประเภทหลักทรัพย์ (โฉนด/นส.3)
            $table->string('Land_Id')->nullable();              // เลขที่โฉนด
            $table->string('Land_ParcelNumber')->nullable();    // เลขที่ดิน
            $table->string('Land_SheetNumber')->nullable();     // ระวาง
            $table->string('Land_TambonNumber')->nullable();    // หน้าสำรวจ
            $table->string('Land_Book')->nullable();            // เล่ม
            $table->string('Land_BookPage')->nullable();        // หน้า

            $table->string('Land_SizeRai')->nullable()->default('0');        // ขนาด ไร่
            $table->string('Land_SizeNgan')->nullable()->default('0');       // ขนาด งาน
            $table->string('Land_SizeSquareWa')->nullable()->default('0');   // ขนาด ตรว.

            $table->string('Land_Zone',150)->nullable();            // ภูมิภาค
            $table->string('Land_Province',150)->nullable();        // ไอดีจังหวัด
            $table->string('Land_District',150)->nullable();        // อำเภอ
            $table->string('Land_Tambon',150)->nullable();          // ตำบล
            $table->string('Land_PostalCode',150)->nullable();      // รหัสไปรษณีย์
            $table->string('Land_Coordinates')->nullable();     // พิกัด
            $table->string('Land_Detail',"MAX")->nullable();    // รายละเอียดที่อยู่

            // ข้อมูลที่ดิน ใหม่ 19/07/2023
            $table->string('Land_BuildingType')->nullable();                // ประเภทสิ่งก่อสร้าง
            $table->string('Land_BuildingKind')->nullable();                // ชนิดบ้าน (บ้านปูน/ไม้/อื่น ๆ)
            $table->string('Land_BuildingStorey')->nullable();              // จำนวนชั้น (1/2/3/มากกว่า3)
            $table->string('Land_BuildingSize')->nullable()->default('0');  // พื้นที่สิ่งก่อสร้าง ตร.ม.

            //------------------ ข้อมูลผู้บันทึก -------------------
            $table->integer('UserZone')->nullable();
            $table->string('UserBranch',191)->nullable();
            $table->string('UserInsert',191)->nullable();

            $table->timestamps();
            $table->softDeletes(); // This adds the 'deleted_at' column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Data_Assets');
    }
}
