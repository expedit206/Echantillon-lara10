<?php

namespace Database\Factories;

use App\Models\Annee;
use App\Models\Niveau;
use App\Models\Filiere;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Etudiant>
 */
class EtudiantFactory extends Factory
{
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
        return [
            'code' => $this->faker->unique()->bothify('####'), // Code unique au format ETU###
            'nom' => $this->faker->lastName, // Nom de famille
            'prenom' => $this->faker->firstName, // Prénom
            'dateNaissance' => $this->faker->date, // Date de naissance
            'lieuNaiss' => $this->faker->firstName, // Prénom
            'email' => $this->faker->unique()->safeEmail, // Email unique
            'numeroTelephone' => $this->faker->phoneNumber, // Numéro de téléphone
            'sexe' => $this->faker->randomElement(['Homme', 'Femme']), // Sexe aléatoire
            'idNiveau' => $niveaux->random()->id, // Référence à un niveau existant ou généré
            'idFiliere' => $filieres->random()->id, // Référence à une filière existante ou générée
            'annee_id' => $annees->random()->id, // Référence à une filière existante ou générée
            'created_at'=>now(),
            'updated_at'=>NULL
        ];
    }
}
