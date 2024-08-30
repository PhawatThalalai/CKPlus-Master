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
        Schema::create('TB_TRAROUND', function (Blueprint $table) {
            $table->id();
            $table->string('CODE',50)->nullable()->comment('รหัส');
            $table->string('NAME',50)->nullable()->comment('ชื่อ');
            $table->string('STATUS',50)->nullable()->comment('สถานะ');
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
        Schema::dropIfExists('TB_TRAROUND');
    }
};
