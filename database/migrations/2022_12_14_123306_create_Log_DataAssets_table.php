<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogDataAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Log_DataAssets', function (Blueprint $table) {
            $table->id();
            $table->integer('Data_id')->nullable();
            $table->date('date')->nullable();
            $table->string('status')->nullable();
            $table->string('model')->nullable();
            $table->string('tagInput')->nullable();
            $table->string('details')->nullable();
            $table->string('UserInsert')->nullable();
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
        Schema::dropIfExists('Log_DataAssets');
    }
}
