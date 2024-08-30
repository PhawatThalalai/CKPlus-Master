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
        Schema::create('Pact_AuditTagparts', function (Blueprint $table) {
            $table->id();
            $table->integer('PactCon_id')->nullable();
            $table->integer('audit_id')->nullable();

            $table->dateTime('date_TrackPart')->nullable();
            $table->string('Status_TrackPart','50')->nullable();
            $table->string('Detail_TrackPart','MAX')->nullable();
            $table->integer('UserZone')->nullable();
            $table->integer('UserBranch')->nullable();
            $table->integer('UserInsert')->nullable();
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
        Schema::dropIfExists('Pact_AuditTagparts');
    }
};
