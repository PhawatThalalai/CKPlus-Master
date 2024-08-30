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
        Schema::create('TB_TypeEmpStatus', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_Status')->nullable();
            $table->string('Code_PLT')->nullable();
            $table->string('Code_Status')->nullable();
            $table->date('Date_Status')->nullable();
            $table->string('Name_Status')->nullable();
            $table->string('Memo_Status',"MAX")->nullable();
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
        Schema::dropIfExists('TB_TypeEmpStatus');
    }
};
