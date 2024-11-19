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
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("student_id"); // aluno
            $table->unsignedBigInteger("classroom_id"); // turma
            $table->unsignedBigInteger("user_id"); // id do usar que fez a chamada
            $table->integer("point"); // 0 significa presente, 1 significa ausente e 2 significa punição
            $table->date("date"); // data da ausensa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points');
    }
};
