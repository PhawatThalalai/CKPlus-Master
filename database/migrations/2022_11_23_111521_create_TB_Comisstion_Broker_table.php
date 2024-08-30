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
        Schema::create('TB_Comisstion_Broker', function (Blueprint $table) {
            $table->id();
            $table->string('Flag')->nullable();                     
            $table->string('Commission_name')->nullable();          
            $table->string('Commission_Interest')->nullable();      
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
        Schema::dropIfExists('TB_Comisstion_Broker');
    }
};
