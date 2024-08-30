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
        Schema::create('TB_CareerCus', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_Career')->nullable();   
            $table->string('Code_PTL')->nullable();
            $table->string('Code_Career')->nullable();
            $table->date('Date_Career')->nullable();
            $table->string('Name_Career')->nullable();  
            $table->string('Memo_Career',"MAX")->nullable();  
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
        Schema::dropIfExists('TB_CareerCus');
    }
};
