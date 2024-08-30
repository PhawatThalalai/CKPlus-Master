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
        Schema::create('Config_RunHP_BillTmp', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_Tags','50')->nullable();
            $table->string('Code_Tags','50')->nullable();
            $table->date('Date_Tags')->nullable();
            $table->integer('Zone_Tags')->nullable();
            $table->string('UserAdd_Tags','50')->nullable();
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
        Schema::dropIfExists('Config_RunHP_BillTmp');
    }
};
