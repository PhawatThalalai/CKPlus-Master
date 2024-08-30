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
        Schema::create('TB_Company', function (Blueprint $table) {
            $table->id();
            $table->integer('Company_Id')->nullable();                           
            $table->integer('Company_Branch')->nullable();
            $table->string('Company_Name')->nullable();
            $table->string('Company_Addr')->nullable();  
            $table->string('Company_Tel')->nullable(); 
            $table->string('Company_Zone')->nullable(); 
            $table->string('Company_Type')->nullable(); 
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
        Schema::dropIfExists('TB_Company');
    }
};
