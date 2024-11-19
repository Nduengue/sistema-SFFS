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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('full_name'); // Nome completo do aluno
            $table->date('birth_date'); // Data de nascimento do aluno
            $table->string('id_type'); // Tipo de Documento de Identidade
            $table->string('id_number')->unique(); // Número do Documento de Identidade
            $table->string('email')->unique(); // Endereço de e-mail do aluno
            $table->string('phone_number')->nullable(); // Número de telefone do aluno
            $table->text('address')->nullable(); // Endereço do aluno
            $table->string('profile_picture')->nullable(); // Foto do Aluno
            $table->text('observations')->nullable(); // Observações Adicionais
            /* $table->json('documents')->nullable(); // Documentos do Aluno */
            $table->integer('user_id')->unique();
            $table->string('student_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
