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
        Schema::create('Rate_SR_LTV', function (Blueprint $table) {
            $table->id();
            $table->string('Status_LTV')->nullable();
            $table->integer('Rating')->default('1');                // ระดับความสำคัญ 1 - 10
            $table->string('TypeAsset');
            $table->string('TypeAssetsPoss')->nullable();
            $table->string('Code_Cus')->nullable();
            $table->integer('OccupiedDay_Start')->nullable();
            $table->integer('OccupiedDay_End')->nullable();
            $table->string('code_car')->nullable();
            $table->integer('Brand_id')->nullable();
            $table->string('Group_car')->nullable();
            $table->string('Evaluate_guar')->nullable();

            $table->string('LTV');

            $table->decimal('RatePrice', 18, 2)->default('1.00');
            $table->string('Mod_PCT')->nullable();
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
        Schema::dropIfExists('Rate_SR_LTV');
    }
};
