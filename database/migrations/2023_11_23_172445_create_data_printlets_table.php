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
        Schema::create('Data_PRINTLET', function (Blueprint $table) {
            $table->id();
            $table->string('LOCAT')->nullable();
            $table->date('LETDOC')->nullable();
            $table->string('DOCNO')->nullable();
            $table->date('DOCDT')->nullable();
            $table->string('CONTNO')->nullable();
            $table->string('GCODE')->nullable();
            $table->date('PRINTDT')->nullable();
            $table->string('PRNNO')->nullable();
            $table->integer('USERID')->nullable();
            $table->date('INPDATE')->nullable();
            $table->integer('POSTLT')->nullable();
            $table->date('REPRINTDT')->nullable();
            $table->integer('REPRINTID')->nullable();
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
        Schema::dropIfExists('Data_PRINTLET');
    }
};
