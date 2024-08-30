<?php

namespace Database\Seeders;

use App\Models\Niveau;
use App\Models\Filiere;
use App\Models\Category;
use App\Models\Enseignant;
use App\Models\Specialite;
use App\Models\UniteValeur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UniteDeValeursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enseignants = Enseignant::all();
        $filieres = Filiere::all();
        $specialites = Specialite::all();
        $semestre =\DB::table('semestres')->get();
        $niveaux = Niveau::all();
        $categories = Category::all();

        $unites = [
            ['nom' => 'Mathematiques', 'description' => 'Cours de base en mathématiques', 'credit' => 5, 'created_at' => now()],
            ['nom' => 'Informatique', 'description' => 'Introduction à la programmation et aux systèmes informatiques', 'credit' => 6, 'created_at' => now()],
            ['nom' => 'Physique', 'description' => 'Concepts fondamentaux de la physique', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Chimie', 'description' => 'Introduction aux principes chimiques', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Biologie', 'description' => 'Étude des organismes vivants', 'credit' => 5, 'created_at' => now()],
            ['nom' => 'Histoire', 'description' => 'Étude des événements passés', 'credit' => 3, 'created_at' => now()],
            ['nom' => 'Géographie', 'description' => 'Étude des paysages et des régions du monde', 'credit' => 3, 'created_at' => now()],
            ['nom' => 'Philosophie', 'description' => 'Introduction à la réflexion philosophique', 'credit' => 2, 'created_at' => now()],
            ['nom' => 'Sociologie', 'description' => 'Étude des sociétés humaines', 'credit' => 3, 'created_at' => now()],
            ['nom' => 'Économie', 'description' => 'Introduction aux principes économiques', 'credit' => 4, 'created_at' => now()],
        ];

        foreach ($unites as &$unite) {
            $unite['enseignant_id'] = $enseignants->random()->id;
            $unite['filiere_id'] = $filieres->random()->id;
            $unite['specialite_id'] = $specialites->random()->id;
            $unite['niveau_id'] = $niveaux->random()->id;
            $unite['semestre_id'] = $semestre->random()->id;
            $unite['category_id'] = $categories->random()->id;
            
            $specialite = Specialite::find($unite['specialite_id']);
            $filiere = Filiere::find($unite['filiere_id']);

            $codePrefix = strtoupper(substr($specialite->nom, 0, 3));

            // Récupère tous les codes existants pour cette filière
            $existingCodes = DB::table('unite_de_valeurs')
                ->where('filiere_id', $unite['filiere_id'])
                ->where('code', 'like', $codePrefix . '%')
                ->pluck('code')
                ->toArray();

                $all=DB::table('unite_de_valeurs')->get();
            // Initialisation du compteur pour cette combinaison unique
            $counter = 1;
            $code = $codePrefix . str_pad($counter, 3, '0', STR_PAD_LEFT);

            // Assure que le code est unique pour cette combinaison
            while (in_array($code, $existingCodes)) {
                $counter++;
                $code = $codePrefix . str_pad($counter, 3, '0', STR_PAD_LEFT);

                // Debug: Affiche le code et les codes existants pour vérifier la boucle
                Log::info("Code généré : $code");
                Log::info("Codes existants : " . implode(', ', $existingCodes));
            }

            $unite['code'] = $code;
        }

        // Insertion des unités de valeur
        DB::table('unite_de_valeurs')->insert($unites);
    }
}
