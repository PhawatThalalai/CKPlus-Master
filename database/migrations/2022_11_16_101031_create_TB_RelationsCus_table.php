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
        Schema::create('TB_RelationsCus', function (Blueprint $table) {
            $table->id();
            $table->string('Flag_Rela')->nullable();
            $table->string('Code_Rela')->nullable();
            $table->date('Date_Rela')->nullable();
            $table->string('Name_Rela')->nullable();
            $table->string('Memo_Rela',"MAX")->nullable();
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
        Schema::dropIfExists('TB_RelationsCus');
    }
};
