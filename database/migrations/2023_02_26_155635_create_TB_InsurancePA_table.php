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
        Schema::create('TB_InsurancePA', function (Blueprint $table) {
            $table->id();
            $table->string('Plan_Insur')->nullable();
            $table->integer('Limit_Insu')->nullable();
            $table->integer('TimeRack12')->nullable();
            $table->integer('TimeRack18')->nullable();
            $table->integer('TimeRack24')->nullable();
            $table->integer('TimeRack30')->nullable();
            $table->integer('TimeRack36')->nullable();
            $table->integer('TimeRack42')->nullable();
            $table->integer('TimeRack48')->nullable();
            $table->integer('TimeRack54')->nullable();
            $table->integer('TimeRack60')->nullable();
            $table->integer('TimeRack66')->nullable();
            $table->integer('TimeRack72')->nullable();
            $table->integer('TimeRack78')->nullable();
            $table->integer('TimeRack84')->nullable();
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
        Schema::dropIfExists('TB_InsurancePA');
    }
};
