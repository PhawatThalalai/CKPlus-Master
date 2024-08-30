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
        Schema::create('TB_ConfigApproveDes', function (Blueprint $table) {
            $table->id();
            $table->string('Code_des');
            $table->text('TxtAsset');
            $table->text('TxtGuaran');
            $table->text('TxtPayee');
            $table->text('TxtBroker');
            $table->text('TxtExpenses');
            $table->text('TxtApprove');
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
        Schema::dropIfExists('TB_ConfigApproveDes');
    }
};
