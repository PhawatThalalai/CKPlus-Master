<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_TypeGroups', function (Blueprint $table) {
            $table->id();
            $table->string('TypeGroup_Status', 255);
            $table->string('TypeGroup_Name', 255);
            $table->string('TypeGroup_Description', 255);
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
        Schema::dropIfExists('TB_TypeGroups');
    }
};
