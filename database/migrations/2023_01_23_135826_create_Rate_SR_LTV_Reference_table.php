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
        Schema::create('Rate_SR_LTV_Reference', function (Blueprint $table) {
            $table->id();
            $table->string('Status')->nullable();
            $table->string('code_car')->nullable();
            $table->integer('Brand_id')->nullable();
            $table->string('Group_car_name')->nullable();
            $table->string('Model_car_name')->nullable();
            $table->integer('Year_Start')->nullable();
            $table->integer('Year_End')->nullable();
            $table->integer('LTV_1')->nullable()->default('0');
            $table->integer('LTV_2')->nullable()->default('0');
            $table->integer('LTV_3')->nullable()->default('0');
            $table->integer('LTV_4')->nullable()->default('0');
            $table->integer('LTV_5')->nullable()->default('0');
            $table->integer('LTV_6')->nullable()->default('0');
            $table->integer('LTV_7')->nullable()->default('0');

            // เพิ่ม 04/01/2024
            $table->integer('LTV_8')->nullable()->default('0');
            $table->integer('LTV_9')->nullable()->default('0');

            // เพิ่ม 18/01/2024
            $table->integer('LTV_10')->nullable()->default('0');
            $table->integer('LTV_11')->nullable()->default('0');

            $table->string('Detail_LTV')->nullable();

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
        Schema::dropIfExists('Rate_SR_LTV_Reference');
    }
};
