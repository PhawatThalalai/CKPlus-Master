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
        Schema::create('Pact_ContractsGuar_Assets', function (Blueprint $table) {
            $table->id();

            $table->integer('DataTag_id');
            $table->integer('PactCon_id');
            $table->integer('Guarantor_id');
            $table->integer('GuarAsset_id');

            //------------------ ข้อมูลผู้บันทึก -------------------
            $table->integer('UserZone')->nullable();
            $table->integer('UserBranch')->nullable();
            $table->integer('UserInsert')->nullable();

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
        Schema::dropIfExists('Pact_ContractsGuar_Assets');
    }
};
