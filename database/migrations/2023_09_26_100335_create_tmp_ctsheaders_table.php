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
        Schema::create('TMP_CTSHEADERS', function (Blueprint $table) {
            $table->id('HEADER_ID');
            $table->string('RECORD_TYPE',1)->nullable();
            $table->string('SEQ_NO',6)->nullable();
            $table->string('BANK_CODE',3)->nullable();
            $table->string('COMPANY_ACCOUNT',10)->nullable();
            $table->string('COMPANY_NAME',40)->nullable();
            $table->string('EFF_DATE',8)->nullable();
            $table->string('SERVICE_CODE',8)->nullable();
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
        Schema::dropIfExists('TMP_CTSHEADERS');
    }
};
