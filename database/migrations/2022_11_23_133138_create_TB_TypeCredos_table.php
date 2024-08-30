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
        Schema::create('TB_TypeCredo', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_Credo')->nullable();                           
            $table->string('Code_Credo')->nullable();
            $table->date('Date_Credo')->nullable();
            $table->string('Name_Credo')->nullable();  
            $table->string('Memo_Credo',"MAX")->nullable(); 
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
        Schema::dropIfExists('TB_TypeCredo');
    }
};
