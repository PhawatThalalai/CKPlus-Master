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
        Schema::create('TB_TypeBroker', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_typeBroker')->nullable();                           
            $table->string('Code_typeBroker')->nullable();
            $table->date('Date_typeBroker')->nullable();
            $table->string('Name_typeBroker')->nullable();  
            $table->string('Memo_typeBroker',"MAX")->nullable();  
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
        Schema::dropIfExists('TB_TypeBroker');
    }
};
