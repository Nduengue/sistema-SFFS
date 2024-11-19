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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('class_name')->unique(); // Nome da turma (único)
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Referência ao instrutor - Users com user_type = 2
            $table->foreignId('shift_id')->constrained('shifts')->onDelete('cascade'); // Referência ao turno
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('vacancies'); // Número de vagas
            $table->text('obs')->nullable();
            $table->string('status');  //0=aceita novas inscrições; 1=não aceita novas inscrições; 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
