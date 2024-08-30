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
        Schema::create('temp_STVATS', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('PatchCon_id')->nullable(); 
            $table->string('LOCAT','5')->nullable();
            $table->string('CONTNO','50')->nullable();
            $table->dateTime('SDATE')->nullable();
            $table->dateTime('STOPVDT')->nullable();
            $table->string('STOPVFL','1')->nullable();
            $table->decimal('TOTPRC',12,2)->nullable();
            $table->decimal('EXP_PRD',18,2)->nullable();
            $table->decimal('EXP_FRM',18,2)->nullable();
            $table->decimal('EXP_TO',18,2)->nullable();
            $table->decimal('EXP_AMT',18,2)->nullable();
            $table->string('USERSTOPV','8')->nullable();
            $table->integer('UserInsert')->nullable();
            $table->integer('UserZone')->nullable();
            $table->integer('UserBranch')->nullable();
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
        Schema::dropIfExists('temp_STVATS');
    }
};
