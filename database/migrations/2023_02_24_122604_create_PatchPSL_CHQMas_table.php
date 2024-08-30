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
        Schema::create('PatchPSL_CHQMas', function (Blueprint $table) {
            $table->id();
            $table->integer('PatchCon_id');
            $table->string('Bill_Id')->nullable();
             $table->string('CONTNO')->nullable();
             $table->string('BILLNO')->nullable();
             $table->date('BILLDT')->nullable();
             $table->string('PAYTYP')->nullable();
             $table->string('PAYFOR')->nullable();
             $table->date('CHQDT')->nullable();
             $table->date('RECVDT')->nullable();
             $table->decimal('CHQAMT',18,2)->nullable();
             $table->string('PAYINACC')->nullable();
             $table->date('PAYDT')->nullable();
             $table->decimal('CHQTMP',18,2)->nullable();
             $table->string('TAXNO')->nullable();
             $table->string('FLAG')->nullable();
             $table->date('CANDT')->nullable();
             $table->string('CAN_USERID')->nullable();
             $table->string('TAXFL')->nullable();
             $table->string('MEMO','MAX')->nullable();
             $table->date('INPDT')->nullable();
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
        Schema::dropIfExists('PatchPSL_CHQMas');
    }
};
