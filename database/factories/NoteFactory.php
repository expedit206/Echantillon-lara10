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

        // Sélection d'un étudiant qui a cette unité de valeur
        $etudiant = Etudiant::whereHas('uniteValeurs', function($query) use ($uniteValeur) {
            $query->where('unite_valeur_id', $uniteValeur->id);
        })->inRandomOrder()->first();

        // Sélection d'un enseignant qui enseigne cette unité de valeur
        $enseignant = $uniteValeur ? $uniteValeur->enseignant()->inRandomOrder()->first() : Enseignant::factory()->create();

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
            'etudiant_id' => $etudiant ? $etudiant->id : null, // Sélection d'un étudiant avec cette unité de valeur
            'unite_valeur_id' => $uniteValeur ? $uniteValeur->id : null, // ID de l'unité de valeur
            'note' => $this->faker->numberBetween(0, 20) . '.' . $this->faker->numberBetween(0, 99), // Génération d'une note
            'enseignant_id' => $enseignant ? $enseignant->id : null, // Sélection d'un enseignant pour cette unité de valeur
            'type' => $typeExamen, // Type de l'examen
        ];
    }
}
