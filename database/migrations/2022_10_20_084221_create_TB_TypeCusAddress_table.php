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
        Schema::create('TB_TypeCusAddress', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_Address')->nullable();                           
            $table->string('Code_Address')->nullable();
            $table->date('Date_Address')->nullable();
            $table->string('Name_Address')->nullable();  
            $table->string('Memo_Address',"MAX")->nullable();  
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
        Schema::dropIfExists('TB_TypeCusAddress');
    }
};
