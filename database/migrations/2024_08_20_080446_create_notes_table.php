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
            $table->id();
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            // $table->foreignId('unite_de_valeur_id')->constrained('unite_de_valeurs')->onDelete('cascade');
            $table->string('uniteValeur'); // idUniteValeur doit être du même type que la clé primaire dans niveaux
            $table->foreign('uniteValeur')->references('nom')->on('unite_de_valeurs')->onUpdate('cascade');

            $table->decimal('note', 5, 2); // Exemple : note avec 2 décimales
            $table->timestamps();
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
