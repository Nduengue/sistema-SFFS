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
        Schema::create('course_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade'); // Chave estrangeira para 'cursos'
            $table->json('contents');
            $table->text('observations')->nullable(); // Observações adicionais
            $table->timestamps();
        });

        /*
            Estrutura de Conteudo de Cursos

            [
                {
                    "title": "Introdução Teórica",
                    "contents": {
                        "1": "conteudo_1",
                        "2": "conteudo_2",
                        "3": "conteudo_3"
                    }
                },
                {
                    "title": "Instalação de Recursos",
                    "contents": {
                        "1": "conteudo_1",
                        "2": "conteudo_2",
                        "3": "conteudo_3"
                    }
                }
            ]
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_contents');
    }
};
