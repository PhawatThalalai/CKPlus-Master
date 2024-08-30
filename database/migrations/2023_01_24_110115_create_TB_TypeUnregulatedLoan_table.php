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
        Schema::create('TB_TypeUnregulatedLoan', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_Sector')->nullable();
            $table->string('Code_PLT')->nullable();
            $table->string('Code_Sector')->nullable();
            $table->date('Date_Sector')->nullable();
            $table->string('Name_Sector')->nullable();
            $table->string('Memo_Sector',"MAX")->nullable();
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
        Schema::dropIfExists('TB_TypeUnregulatedLoan');
    }
};
