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
        Schema::create('TB_listCheckDocs', function (Blueprint $table) {
            $table->id();
            $table->string('status','20')->nullable();
            $table->string('code','20')->nullable();
            $table->string('name_th','MAX')->nullable();
            $table->string('name_en','MAX')->nullable();
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
        Schema::dropIfExists('TB_listCheckDocs');
    }
};
