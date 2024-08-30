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
        Schema::create('Pact_AuditTags', function (Blueprint $table) {
            $table->id();
            $table->integer('PactCon_id')->nullable();
            $table->integer('Flag_Status')->nullable();
            $table->string('Status_Code','50')->nullable();
            $table->dateTime('date_send')->nullable()->comment('วันที่นำส่ง');
            $table->string('userInt_send','255')->nullable()->comment('ผู้นำส่ง');
            $table->string('message_send','MAX')->nullable();
            $table->dateTime('date_received')->nullable()->comment('วันที่รับเอกสาร');
            $table->string('userInt_received','255')->nullable()->comment('ผู้รับเอกสาร');
            $table->dateTime('date_locker')->nullable()->comment('วันที่เข้าเซฟ');
            $table->string('userInt_locker','255')->nullable()->comment('ผู้เข้าเซฟ');
            $table->integer('UserZone')->nullable();
            $table->integer('UserBranch')->nullable();
            $table->integer('UserInsert')->nullable();
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
        Schema::dropIfExists('Pact_AuditTags');
    }
};
