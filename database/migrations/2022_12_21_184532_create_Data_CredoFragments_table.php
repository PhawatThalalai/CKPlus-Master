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
        Schema::create('Data_CredoFragments', function (Blueprint $table) {
            $table->id();
            $table->string('FlagRate')->nullable();
            $table->string('Ratetype_rate')->nullable();
            $table->string('YearStart_rate')->nullable();
            $table->string('YearEnd_rate')->nullable();
            $table->string('InstalmentStart_rate')->nullable();
            $table->string('InstalmentEnd_rate')->nullable();
            $table->string('Interest_rate')->nullable();
            $table->string('referenceNumber')->nullable();
            $table->string('uploadDate')->nullable();
            $table->string('scores')->nullable();
            $table->string('device_id')->nullable();
            $table->text('fragments1')->nullable();
            $table->text('fragments2')->nullable();
            $table->text('fragments3')->nullable();
            $table->text('fragments4')->nullable();
            $table->text('fragments5')->nullable();
            $table->text('fragments6')->nullable();
            $table->text('fragments7')->nullable();
            $table->text('fragments8')->nullable();
            $table->text('fragments9')->nullable();
            $table->text('fragments10')->nullable();
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
        Schema::dropIfExists('Data_CredoFragments');
    }
};
