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
        Schema::create('TB_TypeSecurities', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_Secur')->nullable();
            $table->string('Code_Secur')->nullable();
            $table->date('Date_Secur')->nullable();
            $table->string('Name_Secur')->nullable();
            $table->string('Memo_Secur',"MAX")->nullable();
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
        Schema::dropIfExists('TB_TypeSecurities');
    }
};
