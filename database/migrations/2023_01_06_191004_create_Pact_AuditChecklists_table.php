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
        Schema::create('Pact_AuditChecklists', function (Blueprint $table) {
            $table->integer('PactCon_id')->nullable();
            $table->integer('audit_id')->nullable();
            $table->integer('auditTagprt_id')->nullable();
            $table->string('check_edit','MAX')->nullable();
            $table->string('check_edited','MAX')->nullable();
            $table->string('check_complete','MAX')->nullable();
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
        Schema::dropIfExists('Pact_AuditChecklists');
    }
};
