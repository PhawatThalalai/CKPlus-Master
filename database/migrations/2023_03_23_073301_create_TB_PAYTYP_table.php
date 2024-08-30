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
        Schema::create('TB_PAYTYP', function (Blueprint $table) {
            $table->id();
            $table->string('PAYCODE')->nullable(); 
            $table->string('PAYDESC')->nullable(); 
            $table->string('RLBILL')->nullable(); 
            $table->string('SNCSET')->nullable(); 
            $table->string('ACC_CODE')->nullable(); 
            $table->string('ACCTCOD')->nullable(); 
            $table->string('ACCMSTCOD')->nullable(); 
            $table->string('STATUS')->nullable(); 
            $table->string('MEMO1',"MAX")->nullable(); 
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
        Schema::dropIfExists('TB_PAYTYP');
    }
};
