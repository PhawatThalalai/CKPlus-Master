<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTBTypeAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_TypeAssets', function (Blueprint $table) {
            $table->id();

            $table->string('Flag_TypeAsset');                           
            $table->string('Code_TypeAsset');
            $table->string('Kind_TypeAsset');
            $table->string('Name_TypeAsset');  

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
        Schema::dropIfExists('TB_TypeAssets');
    }
}
