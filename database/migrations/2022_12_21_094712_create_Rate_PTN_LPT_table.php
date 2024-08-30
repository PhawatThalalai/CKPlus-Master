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
        Schema::create('Rate_PTN_LPT', function (Blueprint $table) {
            $table->id();
            $table->date('Date_LPT')->nullable();
            $table->string('Status_LPT')->nullable();
            $table->integer('value_LPT')->nullable();
            $table->string('Detail_LPT')->nullable();
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
        Schema::dropIfExists('Rate_PTN_LPT');
    }
};
