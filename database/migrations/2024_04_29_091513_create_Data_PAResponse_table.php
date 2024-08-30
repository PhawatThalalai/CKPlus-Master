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
        Schema::create('Data_PAResponse', function (Blueprint $table) {
            $table->id();
            $table->bigIncrements('DataCus_id')->nullable();
            $table->bigIncrements('DataPact_id')->nullable();
            $table->string('ContractNumber' )->nullable();
            $table->string('PolicyNumber' )->nullable();
            $table->string('NotificationNumber' )->nullable();
            $table->string('PolicyNumber2')->nullable();
            $table->string('NotificationNumber2' )->nullable();
            $table->string('URLPrint', "MAX")->nullable();
            $table->string('URLPrintCopy', "MAX")->nullable();
            $table->string('URLPrintCard', "MAX")->nullable();
            $table->string('URLPrintApp', "MAX")->nullable();
            $table->string('TransactionID' )->nullable();
            $table->string('TransactionResponseDt' )->nullable();
            $table->string('TransactionResponseTime' )->nullable();
            $table->string('MsgStatusCd' )->nullable();
            $table->string('ErrorMessage' )->nullable();
            $table->string('TaxInvoiceNo' )->nullable();
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
        Schema::dropIfExists('Data_PAResponse');
    }
};
