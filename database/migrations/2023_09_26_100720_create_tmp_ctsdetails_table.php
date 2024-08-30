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
        Schema::create('TMP_CTSDETAILS', function (Blueprint $table) {
            $table->id('DETAIL_ID');
            $table->integer('HEADER_ID')->nullable();
            $table->string('RECORD_TYPE',1)->nullable();
            $table->string('SEQ_NO', 6)->nullable();
            $table->string('BANK_CODE', 3)->nullable();
            $table->string('COMPANY_ACCOUNT', 10)->nullable();
            $table->string('PAYMENT_DATE', 8)->nullable();
            $table->string('PAYMENT_TIME', 6)->nullable();
            $table->string('CUSTOMER_NAME', 50)->nullable();
            $table->string('REF1', 20)->nullable();
            $table->string('REF2', 20)->nullable();
            $table->string('REF3', 20)->nullable();
            $table->string('BRANCH_NO', 4)->nullable();
            $table->string('TELLER_NO', 4)->nullable();
            $table->string('TRANSACTION_KIND', 1)->nullable();
            $table->string('TRANSACTION_CODE', 3)->nullable();
            $table->string('CHEQUE_NO', 7)->nullable();
            $table->string('AMOUNT', 13)->nullable();
            $table->string('CHEQUE_BANK_CODE', 3)->nullable();
            $table->string('POSTBL', 1)->default('N');
            $table->timestamps();
        });

        // Create the index
        Schema::table('TMP_CTSDETAILS', function (Blueprint $table) {
            $table->index(['HEADER_ID', 'REF1', 'REF2']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TMP_CTSDETAILS');
    }
};
