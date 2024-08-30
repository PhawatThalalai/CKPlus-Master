<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTBTypeCusAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_TypeCusAssets', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_Assets')->nullable();                           
            $table->string('Code_Assets')->nullable();
            $table->date('Date_Assets')->nullable();
            $table->string('Name_Assets')->nullable();  
            $table->string('Memo_Assets',"MAX")->nullable();  
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
        Schema::dropIfExists('TB_TypeCusAssets');
    }
}
