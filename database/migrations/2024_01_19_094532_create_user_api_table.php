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
        Schema::create('user_api', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('data_customer_id');
            $table->foreign('data_customer_id')->references('id')->on('Data_Customers');
            $table->string('token');
            $table->string('device_name');
            $table->string('platform');
            $table->string('platform_version');
            $table->string('app_version');
            $table->string('app_version_code');
            $table->string('device_id');
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
        Schema::dropIfExists('user_api');
    }
};
