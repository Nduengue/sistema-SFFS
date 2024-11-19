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
        Schema::create('grade_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal("min")->default(9); // limite de nota
            $table->decimal("med")->default(9); // limite de nota
            $table->decimal("max")->default(20); // limite de nota
            $table->boolean("active")->default(false); // permitir o professor lançar notas
            $table->boolean("term")->default("I"); // permitir o professor lançar notas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_settings');
    }
};
