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
        Schema::create('Stat_CarBrand', function (Blueprint $table) {
            $table->id();
            $table->string('Brand_car')->nullable();               //ยี่ห้อรถยนต์
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
        Schema::dropIfExists('Stat_CarBrand');
    }
};
