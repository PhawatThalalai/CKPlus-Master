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
        Schema::create('Pact_ContractsGuarantor', function (Blueprint $table) {
            $table->id();

            $table->integer('DataTag_id');
            $table->integer('PactCon_id');
            $table->integer('Guarantor_id');
            $table->string('TypeRelation_Cus');

            $table->integer('GuaranAdds1_id')->nullable();
            $table->integer('GuaranAdds2_id')->nullable();
            $table->integer('GuaranAsset_id')->nullable();

            $table->string('TypeSecurities_Guar')->nullable();

            $table->integer('GuaranCareers_id')->nullable();

            //------------------ ข้อมูลผู้บันทึก -------------------
            $table->integer('UserZone')->nullable();
            $table->string('UserBranch',191)->nullable();
            $table->string('UserInsert',191)->nullable();

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
        Schema::dropIfExists('Pact_ContractsGuarantor');
    }
};
