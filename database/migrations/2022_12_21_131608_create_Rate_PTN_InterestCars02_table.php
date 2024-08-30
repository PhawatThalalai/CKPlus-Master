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
        Schema::create('Rate_PTN_InterestCars02', function (Blueprint $table) {
            $table->id();
            $table->string('FlagRate')->nullable();
            $table->string('Ratetype_rate')->nullable();
            $table->string('YearStart_rate')->nullable();
            $table->string('YearEnd_rate')->nullable();
            $table->string('InstalmentStart_rate')->nullable();
            $table->string('InstalmentEnd_rate')->nullable();
            $table->string('Interest_rate')->nullable();
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
        Schema::dropIfExists('Rate_PTN_InterestCars02');
    }
};
