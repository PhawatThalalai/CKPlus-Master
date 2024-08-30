<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Data_CredoCodes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('data_customer_id')->comment('รหัสลูกค้า')->foreign('data_customer_id')->references('id')->on('Data_Customers')->index();
            $table->unsignedBigInteger('data_tag_id')->nullable()->comment('รหัส Tag')->references('id')->on('Data_CusTags')->constraint('fk_credo_tag_id')->index();
            $table->string('statusActive', 10)->comment('สถานะการใช้งาน');
            $table->string('tel_cus', 20)->nullable();
            $table->string('credo_flag', 10)->comment('สถานะการเช็ค Credo');
            $table->dateTime('credo_date')->nullable();
            $table->string('credo_status', 50)->nullable()->comment('หมายเหตุ');
            $table->string('credo_code', 50);
            $table->string('credo_score', 5)->nullable();
            $table->text('credo_score_detail')->nullable();
            $table->string('device_id')->nullable();
            $table->string('device_name')->nullable();
            $table->string('platform')->nullable();
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
        Schema::dropIfExists('Data_CredoCodes');
    }
};
