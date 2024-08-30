<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTBStatusCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_StatusCustomers', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_Cus')->nullable();                           
            $table->string('Code_Cus')->nullable();
            $table->date('Date_Cus')->nullable();
            $table->string('Name_Cus')->nullable();  
            $table->string('Memo_Cus',"MAX")->nullable();  
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
        Schema::dropIfExists('TB_StatusCustomers');
    }
}
