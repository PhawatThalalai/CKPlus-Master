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
        Schema::create('Pact_Indentures', function (Blueprint $table) {
            $table->id();
            $table->integer('Customer_id')->nullable();
            $table->integer('DataTag_id')->nullable();
            $table->integer('PactCon_id')->nullable();

            $table->integer('CusAddress1_id')->nullable();
            $table->integer('CusAddress2_id')->nullable();
            $table->integer('CusAddress3_id')->nullable();
            $table->integer('CusCareer_id')->nullable();
            
            $table->integer('Guarantor_id')->nullable();
            $table->string('TypeRelation_Cus')->nullable();
            $table->integer('GuaranAdds1_id')->nullable();
            $table->integer('GuaranAdds2_id')->nullable();
            $table->string('TypeSecurities_Guar')->nullable();          //แบบค้ำประกัน
            $table->integer('GuaranAsset_id')->nullable();              //ทรัพย์ค้ำประกัน

            $table->integer('Asset_id')->nullable();
            $table->string('Installment_Con')->nullable();              //การผ่อนชำระ
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
        Schema::dropIfExists('Pact_Indentures');
    }
};
