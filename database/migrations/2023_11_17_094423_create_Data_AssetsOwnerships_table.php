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
        Schema::create('Data_AssetsOwnerships', function (Blueprint $table) {
            $table->id();

            $table->string('State_Ownership', 30)->comment('สถานะใช้งาน');

            $table->unsignedBigInteger('DataCus_Id')->comment('ไอดีลูกค้า');
            $table->foreign('DataCus_Id')->references('id')->on('Data_Customers')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('DataAsset_Id')->comment('ไอดีทรัพย์');
            $table->foreign('DataAsset_Id')->references('id')->on('Data_Assets')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('CONTSTAT', 50)->default('N')->comment('สถานะยึด');
            $table->dateTime('DATESTAT', 50)->nullable()->comment('วันที่');

            //------------------ ข้อมูลผู้บันทึก -------------------
            $table->integer('UserZone')->nullable();
            $table->string('UserBranch', 150)->nullable();
            $table->string('UserInsert', 150)->nullable();
            $table->string('UserUpdate', 50)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // เพิ่มคอลัมน์ใหม่
        Schema::table('Data_AssetsDetails', function (Blueprint $table) {
            $table->unsignedBigInteger('DataAssetOwn_Id')->nullable()->comment('ไอดีครอบครอง');
            $table->foreign('DataAssetOwn_Id')->references('id')->on('Data_AssetsOwnerships')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Data_AssetsOwnerships');

        Schema::table('Data_AssetsDetails', function (Blueprint $table) {
            $table->dropForeign(['DataAssetOwn_Id']);
            $table->dropColumn('DataAssetOwn_Id');
        });

    }
};
