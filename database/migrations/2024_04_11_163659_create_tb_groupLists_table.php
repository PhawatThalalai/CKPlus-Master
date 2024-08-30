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
        Schema::create('TB_GroupLists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Groups_id')->constrained('TB_Groups')->index()->name('fk_TB_GroupLists_TB_Groups');
            $table->string('listStatus', 10)->nullable();
            $table->dateTime('listDate');
            $table->string('listBranch_id', 5);
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
        Schema::table('TB_GroupLists', function (Blueprint $table) {
            $table->dropIndex(['Groups_id']);
        });
    }
};
