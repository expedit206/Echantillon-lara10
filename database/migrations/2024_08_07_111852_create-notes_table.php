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
        Schema::create('notes', function (Blueprint $table) {
            $table->id(); // id
            $table->float('valeur'); // float valeur
            $table->date('date'); // Date date
            $table->foreignId('idEtudiant')->constrained('etudiants')->onUpdate('cascade'); // String idEtudiant
            $table->string('uniteValeur'); // idUniteValeur doit être du même type que la clé primaire dans niveaux
            $table->foreign('uniteValeur')->references('nom')->on('unite_de_valeurs')->onUpdate('cascade');
          
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
