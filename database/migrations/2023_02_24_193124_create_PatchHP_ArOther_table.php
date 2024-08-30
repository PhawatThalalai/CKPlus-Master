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
        Schema::create('PatchHP_ArOther', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('PatchCon_id');
            $table->string('CONTNO','50')->nullable();
            $table->string('PAYFOR','50')->nullable();
            $table->decimal('PAYAMT',18,2)->nullable();
            $table->date('ARDATE')->nullable();
            $table->decimal('SMPAY',18,2)->nullable();
            $table->decimal('SMCHQ',18,2)->nullable();
            $table->decimal('BALANCE',18,2)->nullable();
            $table->date('INPDT')->nullable();
            $table->integer('UserZone')->nullable();
            $table->string('UserBranch')->nullable();
            $table->string('UserInsert')->nullable();
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
        Schema::dropIfExists('PatchHP_ArOther');
    }
};
