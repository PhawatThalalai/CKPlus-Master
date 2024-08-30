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
        Schema::create('TB_CrossBanks', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->string('code',50)->nullable();
            $table->string('bank_th',191)->nullable();
            $table->string('company_th',191)->nullable();
            $table->string('accountbank')->unique()->nullable();
            $table->string('details','MAX')->nullable();
            $table->integer('company_type')->nullable();
            $table->integer('zone')->nullable();
            $table->string('zone_th')->nullable();
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
        Schema::dropIfExists('TB_CrossBanks');
    }
};
