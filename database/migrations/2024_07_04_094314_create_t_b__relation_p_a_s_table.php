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
        Schema::create('TB_RelationPA', function (Blueprint $table) {
            $table->id();
            $table->string('flag',10)->nullable();
            $table->string('code',50)->nullable();
            $table->string('name','MAX')->nullable();
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
        Schema::dropIfExists('TB_RelationPA');
    }
};
