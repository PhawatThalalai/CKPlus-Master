<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTBBranchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_Branchs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_Contract')->nullable();
            $table->string('id_Contract_1')->nullable();
            $table->string('Name_Branch')->nullable();
            $table->string('NickName_Branch')->nullable();
            $table->integer('Zone_Branch')->nullable();
            $table->integer('Traget_Branch')->nullable();
            $table->string('province_Branch')->nullable();
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
        Schema::dropIfExists('TB_Branchs');
    }
}
