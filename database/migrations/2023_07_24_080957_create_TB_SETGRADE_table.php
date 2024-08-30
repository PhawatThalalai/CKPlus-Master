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
        Schema::create('TB_SETGRADE', function (Blueprint $table) {
            $table->id();
            $table->string('GRDCOD','50')->nullable();
            $table->string('GRDDES','50')->nullable();
            $table->decimal('GRDCAL10',12,2)->nullable();
            $table->decimal('GRDCAL20',12,2)->nullable();
            $table->decimal('GRDCAL30',12,2)->nullable();
            $table->decimal('GRDCAL40',12,2)->nullable();
            $table->decimal('GRDCAL50',12,2)->nullable();
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
        Schema::dropIfExists('TB_SETGRADE');
    }
};
