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
        Schema::create('TB_Groups', function (Blueprint $table) {
            $table->id();
            $table->string('groupStatus', 10);
            $table->dateTime('groupDate');
            $table->string('groupName', 255);
            $table->string('groupType', 255);
            $table->string('groupHandler', 255)->nullable();
            $table->string('flagSelect', 10);
            $table->string('groupZone', 10);
            $table->string('groupDesc', "MAX")->nullable();
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
        Schema::dropIfExists('TB_Groups');
    }
};

