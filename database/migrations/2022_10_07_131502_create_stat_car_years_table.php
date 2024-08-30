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
        Schema::create('Stat_CarYear', function (Blueprint $table) {
            $table->id();
            $table->integer('Brand_id')->nullable();   //id ยี่ห้อรถยนต์
            $table->integer('Group_id')->nullable();   // id กลุ่มรถยนต์
            $table->integer('Model_id')->nullable();   // id รุ่นรถยนต์
            $table->string('Ratetype_id')->nullable(); // code ประเภทรถยนต์
            $table->string('Year_car')->nullable();     // ปี
            $table->string('PriceAT_car')->nullable();  // ราคา auto
            $table->string('PriceMT_car')->nullable();     // ราคา manual
            $table->string('Status_year')->nullable();  // เปิดปิด yes no

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
        Schema::dropIfExists('Stat_CarYear');
    }
};
