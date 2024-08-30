<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatMotoGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Stat_MotoGroup', function (Blueprint $table) {
            $table->id();
            $table->integer('Brand_id')->nullable();      //id ยี่ห้อรถ
            $table->string('Ratetype_id')->nullable();    // code ประเภทรถ
            $table->string('Group_moto')->nullable();      // ชื่อกลุ่มรถ
            $table->string('Status_group')->nullable();   // เปิดปิด yes no

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
        Schema::dropIfExists('Stat_MotoGroup');
    }
}
