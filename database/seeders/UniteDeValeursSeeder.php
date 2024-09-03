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

        $unites = array_merge([
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
        ], [
            ['nom' => 'Astronomie', 'description' => 'Étude des corps célestes', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Anthropologie', 'description' => 'Étude de l’évolution humaine', 'credit' => 3, 'created_at' => now()],
            ['nom' => 'Littérature', 'description' => 'Analyse des œuvres littéraires', 'credit' => 3, 'created_at' => now()],
            ['nom' => 'Statistiques', 'description' => 'Méthodes de collecte et d’analyse des données', 'credit' => 5, 'created_at' => now()],
            ['nom' => 'Éthique', 'description' => 'Principes moraux et éthiques', 'credit' => 2, 'created_at' => now()],
            ['nom' => 'Droit', 'description' => 'Principes du droit et de la législation', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Gestion', 'description' => 'Principes de gestion et de leadership', 'credit' => 5, 'created_at' => now()],
            ['nom' => 'Finance', 'description' => 'Principes de gestion financière', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Marketing', 'description' => 'Stratégies de marketing et de communication', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Architecture', 'description' => 'Principes de conception architecturale', 'credit' => 6, 'created_at' => now()],
            ['nom' => 'Ingénierie', 'description' => 'Principes de l’ingénierie et de la technologie', 'credit' => 6, 'created_at' => now()],
            ['nom' => 'Électrotechnique', 'description' => 'Principes des circuits électriques', 'credit' => 5, 'created_at' => now()],
            ['nom' => 'Mécanique', 'description' => 'Étude des forces et des mouvements', 'credit' => 5, 'created_at' => now()],
            ['nom' => 'Thermodynamique', 'description' => 'Étude des échanges de chaleur', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Botanique', 'description' => 'Étude des plantes', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Zoologie', 'description' => 'Étude des animaux', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Génétique', 'description' => 'Étude de l’hérédité et des gènes', 'credit' => 5, 'created_at' => now()],
            ['nom' => 'Biochimie', 'description' => 'Étude des processus chimiques dans les organismes vivants', 'credit' => 5, 'created_at' => now()],
            ['nom' => 'Psychologie', 'description' => 'Étude du comportement humain', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Sociolinguistique', 'description' => 'Étude des interactions entre langue et société', 'credit' => 3, 'created_at' => now()],
            ['nom' => 'Journalisme', 'description' => 'Principes et pratiques du journalisme', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Publicité', 'description' => 'Techniques et stratégies publicitaires', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Relations internationales', 'description' => 'Étude des relations entre les États', 'credit' => 5, 'created_at' => now()],
            ['nom' => 'Sécurité informatique', 'description' => 'Principes de la protection des systèmes informatiques', 'credit' => 5, 'created_at' => now()],
            ['nom' => 'Réseaux informatiques', 'description' => 'Principes des réseaux de communication', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Développement web', 'description' => 'Création et gestion de sites web', 'credit' => 5, 'created_at' => now()],
            ['nom' => 'Systèmes d’exploitation', 'description' => 'Principes des systèmes informatiques', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Édition vidéo', 'description' => 'Techniques d’édition et de montage vidéo', 'credit' => 3, 'created_at' => now()],
            ['nom' => 'Photographie', 'description' => 'Techniques et art de la photographie', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Musique', 'description' => 'Étude de la théorie musicale et de la pratique instrumentale', 'credit' => 3, 'created_at' => now()],
            ['nom' => 'Danse', 'description' => 'Techniques et styles de danse', 'credit' => 3, 'created_at' => now()],
            ['nom' => 'Théâtre', 'description' => 'Techniques d’interprétation théâtrale', 'credit' => 3, 'created_at' => now()],
            ['nom' => 'Arts plastiques', 'description' => 'Techniques de peinture et de sculpture', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Design graphique', 'description' => 'Principes de design visuel et graphique', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Gestion de projet', 'description' => 'Principes de gestion de projets et planification', 'credit' => 5, 'created_at' => now()],
            ['nom' => 'Logistique', 'description' => 'Gestion des flux de marchandises et d’informations', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Qualité', 'description' => 'Gestion et assurance de la qualité', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Environnement', 'description' => 'Étude des interactions entre l’homme et son environnement', 'credit' => 5, 'created_at' => now()],
            ['nom' => 'Santé publique', 'description' => 'Principes de la santé à l’échelle de la population', 'credit' => 5, 'created_at' => now()],
            ['nom' => 'Nutrition', 'description' => 'Principes de la nutrition et de l’alimentation', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Gestion des ressources humaines', 'description' => 'Principes de gestion du personnel', 'credit' => 4, 'created_at' => now()],
            ['nom' => 'Éducation', 'description' => 'Principes de l’enseignement et de l’apprentissage', 'credit' => 5, 'created_at' => now()],
            ['nom' => 'Médecine', 'description' => 'Étude des principes médicaux et des soins', 'credit' => 6, 'created_at' => now()],
            ['nom' => 'Pharmacie', 'description' => 'Étude des médicaments et de leur utilisation', 'credit' => 5, 'created_at' => now()],
            ['nom' => 'Odontologie', 'description' => 'Étude des soins dentaires', 'credit' => 5, 'created_at' => now()],
        ]);


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
