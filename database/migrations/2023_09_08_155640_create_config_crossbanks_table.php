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
        Schema::create('Config_CrossBanks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cross_zone');
            $table->string('HeadRecType')->nullable();
            $table->string('HeadSeqNo')->nullable();
            $table->string('HeadBankCode')->nullable();
            $table->string('HeadCompAcc')->nullable();
            $table->string('HeadCompName')->nullable();
            $table->string('HeadEffDate')->nullable();
            $table->string('HeadServiceCode')->nullable();
            $table->string('DetailRecType')->nullable();
            $table->string('DetailSeqNo')->nullable();
            $table->string('DetailBankCode')->nullable();
            $table->string('DetailCompAcc')->nullable();
            $table->string('DetailPaymentDate')->nullable();
            $table->string('DetailPaymentTime')->nullable();
            $table->string('DetailCustName')->nullable();
            $table->string('DetailRef1')->nullable();
            $table->string('DetailRef2')->nullable();
            $table->string('DetailRef3')->nullable();
            $table->string('DetailBranchNo')->nullable();
            $table->string('DetailTellerNo')->nullable();
            $table->string('DetailKindTransaction')->nullable();
            $table->string('DetailTransactionCode')->nullable();
            $table->string('DetailChequeNo')->nullable();
            $table->string('DetailAmount')->nullable();
            $table->string('DetailChequeBankCode')->nullable();
            $table->string('TotalRecType')->nullable();
            $table->string('TotalSeqNo')->nullable();
            $table->string('TotalBankCode')->nullable();
            $table->string('TotalCompAccode')->nullable();
            $table->string('TotalDebitAmount')->nullable();
            $table->string('TotalDebitTransaction')->nullable();
            $table->string('TotalCreditAmount')->nullable();
            $table->string('TotalCreditTransaction')->nullable();
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
        Schema::dropIfExists('Config_CrossBanks');
    }
};
