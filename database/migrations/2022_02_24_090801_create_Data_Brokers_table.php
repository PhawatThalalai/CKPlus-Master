<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataBrokersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Data_Brokers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('DataCus_id')->nullable();
            $table->string('status_Broker')->nullable();
            $table->date('date_Broker')->nullable();
            $table->string('type_Broker')->nullable();
            $table->string('nickname_Broker')->nullable();
            $table->string('location_Broker','MAX')->nullable();
            $table->string('note_Broker','MAX')->nullable();
            $table->string('UserZone')->nullable();
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
        Schema::dropIfExists('Data_Brokers');
    }
}
