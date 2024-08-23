<?php

namespace Database\Factories;

use App\Models\Etudiant;
use App\Models\UniteValeur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $etudiants=Etudiant::all();
        $uniteValeur = UniteValeur::inRandomOrder()->first();

        return [
            'etudiant_id' =>  $etudiants->random()->id, // Génère un nombre entre 1 et 100 pour l'ID de l'étudiant
            'unite_de_valeur_id' => $uniteValeur ? $uniteValeur->id : '', // Génère un nombre entre 1 et 100 pour l'ID du cours
            'note' => $this->faker->numberBetween(0, 20) . '.' . $this->faker->numberBetween(0, 99), // Génère une note entre 0.00 et 20.99
        ];
    }
}
