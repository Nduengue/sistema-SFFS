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
        Schema::create('student_documents', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade'); // FK para a tabela students
            $table->tinyInteger('doc_type'); // doc_type: 1= Documento de Identidade; 2= Habilitações Literarias;
            $table->string('document'); // Caminho do documento (string)
            $table->date('emission_date')->nullable(); // Data de emissão, se aplicável
            $table->date('expiration_date')->nullable(); // Data de expiração, se aplicável
            $table->tinyInteger('status')->default('0'); // 0=Pode ser alterado; 1=Não pode ser alterado; 2=Expirado;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_documents');
    }
};
