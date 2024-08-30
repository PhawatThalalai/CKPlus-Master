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
        Schema::create('TMP_CTSTOTALS', function (Blueprint $table) {
            $table->id('TOTAL_ID');
            $table->integer('HEADER_ID')->nullable();
            $table->string('RECORD_TYPE', 1)->nullable();
            $table->string('SEQ_NO', 6)->nullable();
            $table->string('BANK_CODE', 3)->nullable();
            $table->string('COMPANY_ACCOUNT', 10)->nullable();
            $table->string('TOTAL_DEBIT_AMOUT', 13)->nullable();
            $table->string('TOTAL_DEBIT_TRANSACTION', 6)->nullable();
            $table->string('TOTAL_CREDIT_AMOUNT', 13)->nullable();
            $table->string('TOTAL_CREDIT_TRANSACTION', 6)->nullable();
            $table->timestamps();
        });

        // Create the index
        Schema::table('TMP_CTSTOTALS', function (Blueprint $table) {
            $table->index('HEADER_ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TMP_CTSTOTALS');
    }
};
