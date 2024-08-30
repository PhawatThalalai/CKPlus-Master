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
        Schema::create('TB_TypeCancelCus', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_type')->nullable();
            $table->string('Code_type')->nullable();
            $table->date('Date_type')->nullable();
            $table->string('Name_type')->nullable();
            $table->string('Memo_type',"MAX")->nullable();
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
        Schema::dropIfExists('TB_TypeCancelCus');
    }
};
