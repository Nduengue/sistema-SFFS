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
        Schema::create('summary_calendar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade'); // Referência ao curso
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade'); // Referência à turma
            $table->foreignId('shift_id')->constrained('shifts')->onDelete('cascade'); // Referência ao turno
            $table->integer('duration_months'); // Duração em meses
            $table->integer('year'); // Ano do calendário
            $table->boolean('status')->default(0); // Status (1 - Não pode ser alterado, 0 - Pode ser alterado)
            $table->json('schedule'); // Campo JSON para o cronograma
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('summary_calendar');
    }
};
