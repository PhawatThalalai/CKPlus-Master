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
        Schema::create('TB_PAYFOR', function (Blueprint $table) {
            $table->id();
            $table->string('FORCODE')->nullable(); 
            $table->string('FORDESC')->nullable(); 
            $table->string('SNCSET')->nullable(); 
            $table->string('MEMO1',"MAX")->nullable(); 
            $table->string('ACC_CODE')->nullable(); 
            $table->string('REGFL')->nullable(); 
            $table->string('ESTPRICE')->nullable(); 
            $table->string('STATUS')->nullable(); 
            $table->string('FORDEP')->nullable(); 
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
        Schema::dropIfExists('TB_PAYFOR');
    }
};
