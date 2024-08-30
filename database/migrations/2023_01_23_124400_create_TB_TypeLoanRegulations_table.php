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
        Schema::create('TB_TypeLoanRegulations', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_Loan')->nullable();
            $table->string('Code_PLT')->nullable();
            $table->string('Code_Loan')->nullable();
            $table->date('Date_Loan')->nullable();
            $table->string('Name_Loan')->nullable();
            $table->string('Memo_Loan',"MAX")->nullable();
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
        Schema::dropIfExists('TB_TypeLoanRegulations');
    }
};
