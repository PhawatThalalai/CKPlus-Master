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
        Schema::create('PatchHP_paydue', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('PatchCon_id');
            $table->string('contno','50');
            $table->string('locat','50');
            $table->integer('nopay')->nullable();
            $table->date('ddate')->nullable();
            $table->decimal('vatrt',6,2)->nullable();
            $table->decimal('damt',6,2)->nullable();
            $table->decimal('damt_v',6,2)->nullable();
            $table->decimal('damt_n',6,2)->nullable();
            $table->decimal('capital',6,2)->nullable();
            $table->decimal('interest',12,2)->nullable();
            $table->decimal('intrt',6,2)->nullable();
            $table->decimal('capitalbl',12,2)->nullable();
            $table->string('daycalint','50')->nullable();
            $table->date('date1')->nullable();
            $table->decimal('intamt',12,2)->nullable();
            $table->integer('delayday')->nullable();
            $table->decimal('payment')->nullable();
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
        Schema::dropIfExists('PatchHP_paydue');
    }
};
