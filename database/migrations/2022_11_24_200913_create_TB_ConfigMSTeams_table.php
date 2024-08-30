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
        Schema::create('TB_ConfigMSTeams', function (Blueprint $table) {
            $table->id();
            $table->string('ClientSecret_Id')->nullable(); 
            $table->string('Tenant_Id')->nullable(); 
            $table->string('Client_Id')->nullable(); 
            $table->string('Teams_Chanel')->nullable(); 
            $table->string('Group_Id')->nullable(); 
            $table->string('User_Zone')->nullable(); 
            $table->string('Teams_Active')->nullable(); 
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
        Schema::dropIfExists('TB_ConfigMSTeams');
    }
};
