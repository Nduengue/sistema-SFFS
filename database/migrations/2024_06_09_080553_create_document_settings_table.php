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
        Schema::create('document_settings', function (Blueprint $table) {
            $table->id();
            $table->string("school_name");  //Pe. ERNESTO RAFAEL
            $table->string("county");  // Cacuaco
            $table->string("district");  // Sequle
            $table->string("name_director");// JOSUÉ CELESTINO FRANCISCO GAMBÔA
            $table->string("status_school"); //I Ciclo do Ensino Secundário or II Ciclo do Ensino
            $table->string("number_school")->nullable();// 4078
            $table->string("qr_code")->default(1);// 4078
            $table->string("background_document")->nullable();// certificado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_settings');
    }
};
