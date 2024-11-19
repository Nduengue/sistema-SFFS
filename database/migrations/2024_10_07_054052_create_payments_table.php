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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('registrations')->onDelete('cascade'); // FK para a tabela de Inscrições
            $table->tinyInteger('payment_method')->nullable(); // Método de Pagamento: 1=Transfêrencia Bancaria; 2=TPA; 3=Pagamento por Referência;
            $table->decimal('amount', 12, 2)->nullable();
            $table->string('payment_proof')->nullable(); // Caminho do Comprovativo
            $table->date('payment_date')->nullable(); // Data do Pagamento
            $table->tinyInteger('status')->default('3'); // 0=acção adicional; 1=Validado; 2=Não Validado/Cancelado; 3=Por Validar; 4=Curso Concluido;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
