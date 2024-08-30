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
        Schema::create('Rate_SR_InterestCars01', function (Blueprint $table) {
            $table->id();

            $table->string('Flag');
            $table->integer('TypeLoan_Id');
            $table->integer('Rating')->default('1');                // ระดับความสำคัญ 1 - 10

            $table->integer('Cond_OccupiedTime')->nullable();       // เงื่อนไขเวลาครอบครอง (วัน)
            $table->integer('Cond_YearStart')->nullable();          // เงื่อนไขปีรถ เริ่ม
            $table->integer('Cond_YearEnd')->nullable();            // เงื่อนไขปีรถ จบ
            $table->integer('Cond_InstallmentStart')->nullable();   // เงื่อนไขจำนวนงวด เริ่ม
            $table->integer('Cond_InstallmentEnd')->nullable();     // เงื่อนไขจำนวนงวด จบ
            $table->integer('Cond_TotalStart')->nullable();         // เงื่อนไขยอดจัด เริ่ม
            $table->integer('Cond_TotalEnd')->nullable();           // เงื่อนไขยอดจัด จบ

            $table->decimal('Interest', 18, 2)->default('0.00');
            $table->decimal('Fee_Rate', 18, 2)->default('0.00');
            $table->integer('Fee_Min')->default('0');
            $table->integer('Fee_Max')->default('0');
            $table->decimal('Fine_Rate', 18, 2)->default('0.00');
            $table->string('Installment_REC')->nullable();

            $table->integer('Credo_Cond')->default('0')->nullable();
            $table->integer('Credo_BonusLTV')->default('0')->nullable();

            $table->string('Note', 100)->nullable();

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
        Schema::dropIfExists('Rate_SR_InterestCars01');
    }
};
