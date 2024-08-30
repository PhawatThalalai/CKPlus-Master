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
        Schema::create('data_paydues', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('PatchCon_id');
            $table->string('contno','50');
            $table->string('locat','50');
            $table->integer('nopay')->nullable();
            $table->date('date1')->nullable();
            $table->date('ddate')->nullable();
            $table->decimal('damt',12,2)->nullable();
            $table->decimal('capital',12,2)->nullable();
            $table->decimal('interest',12,2)->nullable();
            $table->decimal('irr',12,6)->nullable();
            $table->decimal('capitalbl',12,2)->nullable();
            $table->decimal('payment',12,2)->nullable();
            $table->decimal('V_PAYMENT',12,2)->nullable();
            $table->decimal('N_PAYMENT',12,2)->nullable();
            $table->integer('daycalint')->nullable();  
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
        Schema::dropIfExists('data_paydues');
    }
};
