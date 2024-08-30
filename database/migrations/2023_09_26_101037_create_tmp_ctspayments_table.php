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
        Schema::create('TMP_CTSPAYMENTS', function (Blueprint $table) {
            $table->id('PAY_ID');
            $table->integer('DETAIL_ID')->nullable();
            $table->string('LOCAT', 5);
            $table->string('CRLOCAT', 5)->nullable();
            $table->string('REFNO1', 15);
            $table->string('CUSCOD', 15);
            $table->string('SNAME', 8)->nullable();
            $table->string('NAME1', 50)->nullable();
            $table->string('NAME2', 50)->nullable();
            $table->string('CONTNO', 15)->default('');
            $table->decimal('TOTUPAY', 12, 2)->default(0);
            $table->decimal('ARBAL', 12, 2)->default(0);
            $table->decimal('TOTLKANG', 12, 2)->default(0);
            $table->decimal('KINTAMT', 12, 2)->default(0);
            $table->decimal('EXPREAL', 12, 2)->default(0);
            $table->string('GRDCOD', 2)->default('');
            $table->decimal('GRDCAL', 12, 2)->default(0);
            $table->decimal('PAYLIMITAMT', 12, 2)->default(0);
            $table->date('TMPBILDT')->nullable();
            $table->string('TMPBILNO', 12)->default('');
            $table->date('PAYDATE')->nullable();
            $table->time('PAYTMIE')->nullable();
            $table->decimal('PAYAMT', 12, 2)->default(0);
            $table->decimal('PAYINT', 12, 2)->default(0);
            $table->decimal('PAYAMOUNT', 12, 2);
            $table->string('BANKACCNO', 10)->nullable();
            $table->string('BILLCOLL', 8)->nullable();
            $table->string('POSTBL', 1)->default('N');
            $table->string('SCHEMACUS', 8)->nullable();
            $table->string('USERID', 8)->nullable();
            $table->timestamp('INPDATE')->nullable();
            $table->string('FLCHECK', 1)->default('N');
            $table->date('LAST_NOTEDT')->nullable();
            $table->timestamps();
        });

        // Create the index
        Schema::table('TMP_CTSPAYMENTS', function (Blueprint $table) {
            $table->index(['REFNO1', 'LOCAT']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TMP_CTSPAYMENTS');
    }
};
