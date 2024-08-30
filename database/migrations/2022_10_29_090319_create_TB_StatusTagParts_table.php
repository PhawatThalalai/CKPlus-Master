<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTBStatusTagPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_StatusTagParts', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_StatusTag')->nullable();                           
            $table->string('Code_StatusTag')->nullable();
            $table->date('Date_StatusTag')->nullable();
            $table->string('Name_StatusTag')->nullable();  
            $table->string('Memo_StatusTag',"MAX")->nullable();  
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
        Schema::dropIfExists('TB_StatusTagParts');
    }
}
