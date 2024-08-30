<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTBTypeLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_TypeLoans', function (Blueprint $table) {
            $table->id();
            $table->string('Code_PLT')->nullable();
            $table->string('id_rateType')->nullable();
            $table->string('Loan_Code')->nullable();
            $table->string('Loan_Name')->nullable();
            $table->string('Loan_Group')->nullable();
            $table->integer('Loan_Com')->nullable();
            $table->string('Description',"MAX")->nullable();
            $table->string('Flagzone_PTN')->nullable();
            $table->string('Flagzone_HY')->nullable();
            $table->string('Flagzone_NK')->nullable();
            $table->string('Flagzone_KB')->nullable();
            $table->string('Flagzone_SR')->nullable();
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
        Schema::dropIfExists('TB_TypeLoans');
    }
}
