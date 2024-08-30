<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_TokenApi', function (Blueprint $table) {
            $table->id();
            $table->string('token_name')->nullable();
            $table->string('token_id')->nullable();
            $table->string('secret_key')->nullable();
            $table->string('type_token')->nullable();
            $table->date('token_exp')->nullable();
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
        Schema::dropIfExists('TB_TokenApi');
    }
};
