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
        Schema::create('Data_Provinces', function (Blueprint $table) {
            $table->id();
            $table->integer('Postcode_pro')->nullable();
            $table->string('Tambon_pro')->nullable();
            $table->string('District_pro')->nullable();
            $table->string('Province_pro')->nullable();
            $table->string('Zone_pro')->nullable();
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
        Schema::dropIfExists('Data_Provinces');
    }
};
