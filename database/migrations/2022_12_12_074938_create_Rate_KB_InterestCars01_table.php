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
        Schema::create('Rate_KB_InterestCars01', function (Blueprint $table) {
            $table->id();
            $table->string('Flag');
            $table->string('Status_Code');
            $table->string('Possessiontypecar');
            $table->string('Possession_rang');
            $table->integer('Possession_month');
            $table->string('grade');
            $table->integer('Percen_Rate');
            $table->float('Interrests');
            $table->string('Payment_Status');
            $table->float('Process_Rate');
            $table->float('Total_Rate');
            $table->string('Rate_Cache');
            $table->string('Type_leasing');
            $table->string('Type_Loan');
            $table->string('Text_alert');
            $table->string('Text_alert2');
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
        Schema::dropIfExists('Rate_KB_InterestCars01');
    }
};
