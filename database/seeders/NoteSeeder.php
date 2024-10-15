<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\Etudiant;
use App\Models\UniteValeur;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $note = Note::create([
                'etudiant_id' => Etudiant::inRandomOrder()->first()->id,  // Choix aléatoire d'un étudiant
                'unite_valeur_id' => UniteValeur::inRandomOrder()->first()->id,  // Choix aléatoire d'une unité de valeur
                'note' => rand(50, 100) / 10,  // Génère une note aléatoire entre 5.00 et 10.00
                'type' => ['Controle continu', 'Normale', 'Rattrapage'][array_rand(['Controle continu', 'Normale', 'Rattrapage'])], // Choix aléatoire du type de note
                'enseignant_id' => Professeur::inRandomOrder()->first()->id ?? null, // Choix aléatoire d'un enseignant (ou nul)
            ]);
        }
        // Note::factory()->count(5)->create();
    }
}

