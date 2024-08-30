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
        Schema::create('Log_InsideTracks', function (Blueprint $table) {
            $table->id();
            $table->integer('Patch_id')->nullable();
            $table->date('date')->nullable();
            $table->string('status')->nullable();
            $table->string('model')->nullable();
            $table->string('tagInput')->nullable();
            $table->string('details')->nullable();
            $table->string('UserInsert')->nullable();
            $table->string('log_type')->nullable();
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
        Schema::dropIfExists('Log_InsideTracks');
    }
};
