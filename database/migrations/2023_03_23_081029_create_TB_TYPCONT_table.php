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
        Schema::create('TB_TYPCONT', function (Blueprint $table) {
            $table->id();
            $table->string('FLAG')->nullable(); 
            $table->string('CONTTYP')->nullable(); 
            $table->string('DATECONT')->nullable(); 
            $table->string('CONTDESC')->nullable(); 
            $table->string('EXPFM')->nullable(); 
            $table->string('EXPTO')->nullable(); 
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
        Schema::dropIfExists('TB_TYPCONT');
    }
};
