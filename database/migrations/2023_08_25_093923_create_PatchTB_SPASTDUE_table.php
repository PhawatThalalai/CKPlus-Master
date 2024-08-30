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
        Schema::create('PatchTB_SPASTDUE', function (Blueprint $table) {
            $table->id();

            $table->string('LOCAT',10)->comment('สาขาของสัญญา');
            $table->string('CONTNO',15)->comment('เลขที่สัญญา ใช้เชื่อมหาตารางอื่น');
            $table->string('CODLOAN',15)->nullable()->comment('ประเภทสินเชื่อ 1 เงินกู้ 2 เช่าซื้อ');
            $table->string('TYPECONT',15)->comment('ประเภทสัญญา 01 02');
            $table->string('BILLCOLL',10)->comment('ทีมตาม สาขา');
            $table->integer('FOLCODE')->nullable()->comment('ทีมตาม User');
            $table->string('SALECOD',10)->comment('พนักงานขาย ตามข้อมูลของสัญญา');
            $table->string('CONTSTAT',10)->omment('สถานะสัญญา รหัส');

            $table->date('FDATE')->nullable();
            $table->date('LDATE')->nullable();
            $table->date('YDATE')->nullable();

            $table->date('LPAYD')->nullable();
            $table->decimal('LPAYA',15,2)->nullable();
            
            $table->date('DUEDATE')->nullable();
            $table->decimal('TOTPRC',15,2)->nullable();

            $table->decimal('TOTNOPAY',3,0)->nullable();
            $table->decimal('TOTUPAY',15,2)->nullable();

            $table->decimal('DAMT',15,2)->nullable();
            $table->decimal('KDAMT',15,2)->nullable();
            $table->decimal('KARBAL',15,2)->nullable();
            $table->decimal('PAYBEFOR',15,2)->nullable();
            $table->decimal('PAYDUE',15,2)->nullable();
            $table->decimal('PAYKANG',15,2)->nullable();
            $table->decimal('PARBAL',15,2)->nullable();

            $table->integer('LOSTDAY')->nullable();

            $table->decimal('EXPREAL',12,2)->nullable();
            $table->decimal('REXP_PRD',6,2)->nullable();
            $table->decimal('NEXT_DAMT',15,2)->nullable();
            $table->decimal('NEXT_KDAMT',15,2)->nullable();

            $table->integer('PAST_DAY')->nullable();
            $table->decimal('NEXT_EXPREAL',12,2)->nullable();
            $table->decimal('KINTAMT',15,2)->nullable();
            $table->decimal('PAYINT',15,2)->nullable();

            $table->decimal('FOLLOWAMT',12,2)->nullable();
            $table->decimal('PAYFOLLOW',12,2)->nullable();
            $table->decimal('KAROTHR',12,2)->nullable();

            $table->decimal('LASTNOPAY',3,0)->nullable();

            $table->date('LAST_ASSIGNDT')->nullable();
            $table->date('SUMARYDATE')->nullable();
            $table->string('GRDCOD',1)->nullable();
            $table->decimal('EXP_FRM',3,0)->nullable();
            $table->decimal('EXP_TO',3,0)->nullable();
            $table->date('DATE_EXC')->nullable();

            $table->string('GNAME',50)->nullable();
            $table->string('STATUS',50)->nullable();

            $table->integer('ZONE')->nullable();
            $table->decimal('TRACK_FEE',18,0)->nullable();
            $table->decimal('TRACK_SUM',18,0)->nullable();
            $table->decimal('LOW_FEE',18,0)->nullable();
            $table->decimal('LOW_SUM',18,0)->nullable();
            
            $table->string('GroupingState',10)->nullable()->comment('สถานการแบ่งงาน, Y = แบ่งแล้ว');
            $table->string('GroupingType',10)->nullable()->comment('ประเภทการแบ่งงาน (โทร/ตาม/ที่ดิน)');
            $table->integer('GroupingTemp')->nullable()->comment('จำกลุ่มการแบ่งงาน');

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
        Schema::dropIfExists('PatchTB_SPASTDUE');
    }
};
