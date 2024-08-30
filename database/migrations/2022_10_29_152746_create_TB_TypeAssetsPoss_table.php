<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTBTypeAssetsPossTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_TypeAssetsPoss', function (Blueprint $table) {
            $table->id();

            $table->string('Flag_TypePoss');
            $table->string('Code_TypePoss');
            $table->string('Name_TypePoss');

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
        Schema::dropIfExists('TB_TypeAssetsPoss');
    }
}
