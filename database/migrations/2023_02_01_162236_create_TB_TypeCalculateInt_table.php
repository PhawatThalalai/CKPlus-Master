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
        Schema::create('TB_TypeCalculateInt', function (Blueprint $table) {
            $table->id();
            $table->string('Status',"50")->nullable();
            $table->string('Code_CalInt',"50")->nullable();
            $table->string('Details_CalInt',"255")->nullable();
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
        Schema::dropIfExists('TB_TypeCalculateInt');
    }
};
