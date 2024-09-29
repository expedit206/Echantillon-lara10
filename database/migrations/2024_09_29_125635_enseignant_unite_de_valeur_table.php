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
        Schema::create('enseignant_unite_valeur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enseignant_id')->constrained()->onDelete('cascade');
            $table->foreignId('unite_valeur_id')->constrained('unite_de_valeurs')->onDelete('cascade');
            
            // Ajout des relations avec les tables specialites, filieres et niveaux
            $table->foreignId('specialite_id')->constrained()->onDelete('cascade');
            $table->foreignId('filiere_id')->constrained()->onDelete('cascade');
            $table->foreignId('niveau_id')->constrained()->onDelete('cascade');
    
            $table->timestamps(); // Ajoute les colonnes created_at et updated_at
        });
    
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
