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
        Schema::create('TB_TargetAmounts', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('TypeTarget_id')->nullable();
            $table->Integer('Target_Branch')->nullable();
            $table->Integer('Target_User')->nullable();
            $table->string('Target_Month')->nullable(); 
            $table->string('Target_Year')->nullable(); 
            $table->Integer('Target_Typcus')->nullable();
            $table->Integer('Target_Amount')->nullable();
            $table->string('Target_Zone')->nullable(); 
            $table->string('created_month')->nullable(); 
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
        Schema::dropIfExists('TB_TargetAmounts');
    }
};
