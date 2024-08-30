<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTBPromotiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_promotios', function (Blueprint $table) {
            $table->id();
            $table->integer('Zone_pro')->nullable();
            $table->string('Status_pro')->nullable();
            $table->string('Type_pro')->nullable();
            
            $table->string('Code_pro')->nullable();
            $table->string('Name_pro')->nullable();
            $table->integer('Value_pro')->nullable();
            $table->string('Detail_pro',"MAX")->nullable();
            $table->date('Start_pro')->nullable();
            $table->date('End_pro')->nullable();
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
        Schema::dropIfExists('TB_promotios');
    }
}
