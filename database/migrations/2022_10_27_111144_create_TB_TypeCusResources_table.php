<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTBTypeCusResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_TypeCusResources', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_CusResource')->nullable();                           
            $table->string('Code_CusResource')->nullable();
            $table->date('Date_CusResource')->nullable();
            $table->string('Name_CusResource')->nullable();  
            $table->string('Memo_CusResource',"MAX")->nullable(); 
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
        Schema::dropIfExists('TB_TypeCusResources');
    }
}
