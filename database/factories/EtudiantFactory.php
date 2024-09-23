<?php

namespace Database\Factories;

use App\Models\Annee;
use App\Models\Niveau;
use App\Models\Filiere;
use App\Models\Specialite;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Etudiant>
 */
class EtudiantFactory extends Factory
{
    // Variable statique pour le compteur
    protected static $counter = 1;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $niveaux = Niveau::all();
        $filieres = Filiere::all();
        $annees = Annee::all();
        $specialites = Specialite::all();
        
        // Sélection aléatoire de niveau, filière et spécialité
        // $etudiants=Etudiant::all()
        $niveau = $niveaux->random();
        $filiere = $filieres->random();
        $specialite = $specialites->random();
        $nom = $this->faker->lastName;

        // Générer le matricule selon le format demandé
        $matricule = sprintf(
            '%d%s%s%s-%03d',
            $niveau->id, // ID du niveau
            strtoupper(substr($filiere->nom, 0, 3)), // 3 premières lettres de la filière
            strtoupper(substr($specialite->nom, 0, 3)), // 3 premières lettres de la spécialité
            strtoupper(substr($nom, 0, 3)), // 3 premières lettres du nom
            self::$counter // Numéro qui s'incrémente
        );

        // Incrémenter le compteur pour le prochain étudiant
        self::$counter++;

        return [
            'matricule' => $matricule, // Matricule personnalisé
            'password' => bcrypt('password'), // Génération du mot de passe
            'nom' => $nom, // Nom de famille
            'prenom' => $this->faker->firstName, // Prénom
            'dateNaissance' => $this->faker->date, // Date de naissance
            'lieuNaiss' => $this->faker->city, // Lieu de naissance
            'email' => $this->faker->unique()->safeEmail, // Email unique
            'numeroTelephone' => $this->faker->phoneNumber, // Numéro de téléphone
            'sexe' => $this->faker->randomElement(['Homme', 'Femme']), // Sexe aléatoire
            'niveau_id' => $niveau->id, // Référence à un niveau existant ou généré
            'filiere_id' => $filiere->id, // Référence à une filière
            'annee_id' => $annees->random()->id, // Référence à une année
            'specialite_id' => $specialite->id, // Référence à une spécialité
            'created_at' => now(),
            'updated_at' => null
        ];
    }
}
