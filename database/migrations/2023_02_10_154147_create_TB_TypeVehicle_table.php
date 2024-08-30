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
        Schema::create('TB_TypeVehicle', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_Vehicle')->nullable();
            $table->string('Code_PLT')->nullable();
            $table->date('Date_Vehicle')->nullable();
            $table->string('Name_Vehicle')->nullable();
            $table->string('Cond_Regex')->nullable();
            $table->string('Memo_Vehicle',"MAX")->nullable();
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
        Schema::dropIfExists('TB_TypeVehicle');
    }
};
