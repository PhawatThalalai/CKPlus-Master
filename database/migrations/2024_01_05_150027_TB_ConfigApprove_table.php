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
        Schema::create('TB_ConfigApprove', function (Blueprint $table) {
            $table->id();
            $table->string('Code_Cus');
            $table->string('Loan_Code');
            $table->string('Code_des');
            $table->foreignId('Code_des')->constrained()->index();  // สร้าง foreign key เพื่อเชื่อมโยงกับ table2 และสร้าง index
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
        Schema::dropIfExists('TB_ConfigApprove');
    }
};
