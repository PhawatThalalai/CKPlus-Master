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
        Schema::create('TB_TypePurposeCodes', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_Purpose')->nullable();
            $table->string('Code_PLT')->nullable();
            $table->string('Code_Purpose')->nullable();
            $table->date('Date_Purpose')->nullable();
            $table->string('Name_Purpose')->nullable();
            $table->string('Memo_Purpose',"MAX")->nullable();
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
        Schema::dropIfExists('TB_TypePurposeCodes');
    }
};
