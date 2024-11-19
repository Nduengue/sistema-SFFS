<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('certificate_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("student_id");
            $table->unsignedBigInteger("classroom_id");
            $table->string("term1");
            $table->string("name_teachers")->nullable();
            $table->string("name_projects")->nullable();
            $table->string("start")->nullable();    // dia de inicio
            $table->string("end")->nullable();      // dia do fim
            $table->string("hours")->nullable();    // carga horaria
            $table->date("date_start")->nullable(); // data do inicio
            $table->date("date");
            $table->boolean("active")->default(true);
            $table->string("academic_year");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_courses');
    }
};
