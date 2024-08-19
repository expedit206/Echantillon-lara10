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
                $table->date('lieuNaissance'); // Date dateNaissance
                $table->string('email')->unique(); // String email
                $table->string('photo')->nullable(); // Chemin de la photo (nullable si facultatif)

                $table->string('numeroTelephone'); // String numeroTelephone
                $table->string('sexe'); // String sexe
                $table->foreignId('idNiveau')->constrained('niveaux')->onUpdate('cascade'); // int idNiveau
                $table->foreignId('idFiliere')->constrained('filieres')->onUpdate('cascade'); // int idFiliere
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
