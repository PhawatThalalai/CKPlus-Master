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
        Schema::create('Config_Credos', function (Blueprint $table) {
            $table->id();
            $table->string('status','50')->nullable();
            $table->string('Score_rate','50')->nullable();
            $table->string('Percen_rate','50')->nullable();
            $table->string('Notes','MAX')->nullable();
            $table->string('UserZone','50')->nullable();
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
        Schema::dropIfExists('Config_Credos');
    }
};
