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
            Schema::create('etudiants', function (Blueprint $table) {
                $table->id(); // id
                $table->char('code', 4)->unique(); // String code
                $table->string('nom'); // String nom
                $table->string('prenom'); // String prenom
                $table->date('dateNaissance'); // Date dateNaissance
                $table->string('lieuNaiss'); // Date dateNaissance
                $table->string('email')->unique(); // String email
                $table->string('photo')->nullable(); // Chemin de la photo (nullable si facultatif)
                $table->string('numeroTelephone'); // String numeroTelephone
                $table->string('sexe'); // String sexe
                $table->foreignId('niveau_id')->constrained('niveaux')->onUpdate('cascade'); // int niveau_id
                $table->foreignId('filiere_id')->constrained('filieres')->onUpdate('cascade');
                $table->foreignId('specialite_id')->constrained('specialites')->onUpdate('cascade');
                $table->foreignId('annee_id')->constrained('annees')->onUpdate('cascade');
                 // int filiere_id
                $table->timestamps(); // created_at et updated_at
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};
