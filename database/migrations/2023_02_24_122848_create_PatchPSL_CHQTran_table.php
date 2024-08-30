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
        Schema::create('PatchPSL_CHQTran', function (Blueprint $table) {
            $table->id();
            $table->integer('PatchCon_id');
            $table->integer('ChqMas_id');
            $table->string('TMBILL')->nullable();
            $table->date('TMBILDT')->nullable();
            $table->string('CHQNO')->nullable();
            $table->string('PAYFOR')->nullable();
            $table->string('CONTNO')->nullable();
            $table->string('PAYTYP')->nullable();
            $table->decimal('PAYAMT',18,2)->nullable();
            $table->decimal('PAYAMT_N',18,2)->nullable();
            $table->decimal('PAYAMT_V',18,2)->nullable();
            $table->decimal('DISCT',18,2)->nullable();
            $table->decimal('PAYINT',18,2)->nullable();
            $table->decimal('DSCINT',18,2)->nullable();
            $table->decimal('NETPAY',18,2)->nullable();
            $table->date('PAYDT')->nullable();
            $table->integer('NOPAY')->nullable();
            $table->string('F_PAR')->nullable();
            $table->string('F_PAY')->nullable();
            $table->string('L_PAR')->nullable();
            $table->string('L_PAY')->nullable();
            $table->string('TAXNO')->nullable();
            $table->string('TAXFL')->nullable();
            $table->string('FLAG')->nullable();
            $table->date('CANDT')->nullable();
            $table->string('CAN_USERID')->nullable();
            $table->decimal('VATRTPAY',18,2)->nullable();
            $table->decimal('VATAMTPAY',18,2)->nullable();
            $table->decimal('DEBT_BALANCE',18,2)->nullable();
            $table->string('UserInsert')->nullable();
            $table->string('UserBranch')->nullable();
            $table->string('UserZone')->nullable();
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
        Schema::dropIfExists('PatchPSL_CHQTran');
    }
};
