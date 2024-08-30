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
        Schema::create('TB_ConfigSMS', function (Blueprint $table) {
            $table->id();
            $table->string('status', 50);
            $table->text('api_key');
            $table->text('secret_key');
            $table->string('name', 50);
            $table->text('project_key');
            $table->string('description', "MAX");
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
        Schema::dropIfExists('TB_ConfigSMS');
    }
};
