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
        Schema::create('TB_StatusCon', function (Blueprint $table) {
            $table->id();
            $table->string('Active',3)->default('yes');
            $table->integer('order')->default(0);
            $table->string('Name_StatusCon',100)->nullable();
            $table->string('Memo_StatusCon',100)->nullable();
            $table->string('Description',100)->nullable();
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
        Schema::dropIfExists('TB_StatusCon');
    }
};
