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
        Schema::create('PatchPSL_AROTHR', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('PatchCon_id')->nullable(); 
            $table->string('ARCONT')->nullable(); 
            $table->string('TSALE')->nullable(); 
            $table->string('CUSCODE')->nullable(); 
            $table->string('LOCAT')->nullable(); 
            $table->string('PAYFOR')->nullable(); 
            $table->string('PAYAMT')->nullable(); 
            $table->string('VATRT')->nullable(); 
            $table->string('TXTNO')->nullable(); 
            $table->date('ARDATE')->nullable(); 
            $table->string('SMPAY')->nullable(); 
            $table->string('SMCHQ')->nullable(); 
            $table->string('BALANCE')->nullable(); 
            $table->string('USERID')->nullable(); 
            $table->date('INPDT')->nullable(); 
            $table->date('DDATE')->nullable(); 
            $table->string('FOLLOWCODE')->nullable(); 
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
        Schema::dropIfExists('PatchPSL_AROTHR');
    }
};
