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
        Schema::create('TB_TypeFactors', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_Factors')->nullable();
            $table->string('Code_PLT')->nullable();
            $table->string('Code_Factors')->nullable();
            $table->date('Date_Factors')->nullable();
            $table->string('Name_Factors')->nullable();
            $table->string('Memo_Factors',"MAX")->nullable();
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
        Schema::dropIfExists('TB_TypeFactors');
    }
};
