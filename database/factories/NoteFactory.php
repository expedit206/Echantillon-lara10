<?php

namespace Database\Factories;

use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Note;
use App\Models\UniteValeur;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    public function definition(): array
    {
        // Sélection aléatoire d'une unité de valeur
        $uniteValeur = UniteValeur::inRandomOrder()->first();

        if (!$uniteValeur) {
            return []; // Retourner un tableau vide si aucune unité de valeur n'est trouvée
        }

        // Sélection d'un étudiant qui a cette unité de valeur
        $etudiant = Etudiant::whereHas('uniteValeurs', function($query) use ($uniteValeur) {
            $query->where('unite_valeur_id', $uniteValeur->id);
        })->inRandomOrder()->first();

        if (!$etudiant) {
            return []; // Retourner un tableau vide si aucun étudiant n'est trouvé pour l'unité de valeur
        }

        // Sélection d'un enseignant qui enseigne cette unité de valeur
        $enseignant = $uniteValeur->enseignant()->inRandomOrder()->first() ?? Enseignant::factory()->create();

        // Type de l'examen
        $typeExamen = $this->faker->randomElement(['Controle continu', 'Normale', 'Rattrapage']);

        // Vérification de l'existence d'une note pour cette combinaison
        $noteExistante = Note::where('etudiant_id', $etudiant->id)
            ->where('unite_valeur_id', $uniteValeur->id)
            ->where('type', $typeExamen)
            ->exists();

        if ($noteExistante) {
            // Si la note existe déjà, retourner un tableau vide pour éviter la duplication
            return [];
        }

        return [
            'etudiant_id' => $etudiant->id, // ID de l'étudiant
            'unite_valeur_id' => $uniteValeur->id, // ID de l'unité de valeur
            'note' => $this->faker->numberBetween(0, 20) . '.' . $this->faker->numberBetween(0, 99), // Génération d'une note
            'enseignant_id' => $enseignant->id, // ID de l'enseignant
            'type' => $typeExamen, // Type de l'examen
        ];
    }
}
