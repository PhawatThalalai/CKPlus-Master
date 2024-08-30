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
        Schema::create('TB_GROUPDEBT', function (Blueprint $table) {
            $table->id();
            $table->string('CODE','50')->nullable();
            $table->string('MEMO','255')->nullable();
            $table->string('FLAG','1')->nullable();
            $table->decimal('FEXP_PRD',12,2)->nullable();
            $table->decimal('FEXP_INT',12,2)->nullable();
            $table->decimal('FEXP_OTR',12,2)->nullable();
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
        Schema::dropIfExists('TB_GROUPDEBT');
    }
};
