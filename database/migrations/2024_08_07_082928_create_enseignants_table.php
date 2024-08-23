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
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id(); // id
            $table->string('nom'); // String nom
            $table->string('prenom'); // String prenom
            $table->string('sexe'); // Sexe (masculin, féminin, autre)
            $table->string('email')->unique(); // String email
            $table->string('password'); // String mot de passe

            // Ajout des nouveaux champs
            $table->date('dateNaiss'); // Date de naissance
            $table->string('lieuNaiss'); // Lieu de naissance
            $table->string('nationalite'); // Nationalité
            $table->string('mobile'); // Numéro de mobile
            $table->string('photo')->nullable(); // Chemin de la photo (nullable si facultatif)
            $table->string('profession'); // Profession
            $table->string('diplome'); // Diplôme
            $table->foreignId('annee_id')->constrained('annees');
            $table->decimal('salaire', 10, 2); // Salaire avec deux décimales
            $table->string('typeContrat'); // Type de contrat (CDI, CDD, etc.)
            $table->date('debutContrat'); // Date de début de contrat
            $table->date('finContrat')->nullable(); // Date de fin de contrat (nullable si contrat indéterminé)

            // Clé étrangère pour unité de valeur

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseignants');
    }
};
