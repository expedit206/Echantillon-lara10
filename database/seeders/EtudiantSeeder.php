<?php

namespace Database\Seeders;

use App\Models\Etudiant;
use App\Models\Niveau;
use App\Models\Filiere;
use App\Models\Specialite;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EtudiantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nombre d'étudiants à créer
        // $nombreEtudiants = 5;

        // Création des étudiants via la factory
        // $etudiants = Etudiant::factory($nombreEtudiants)->create();

        // Insérer un dernier étudiant spécifique avec email et mot de passe
        for ($i = 1; $i <= 10; $i++) {
            $dernierEtudiant = Etudiant::create([
                'matricule' => 'ETD00' . $i,
                'nom' => 'Nom ' . $i,
                'prenom' => 'Prenom ' . $i,
                'email' => 'etudiant' . $i . '@exemple.com',
                'password' => Hash::make('password' . $i),
                'dateNaissance' => '2000-01-0' ,
                'lieuNaiss' => 'Lieu ' . $i,
                'photo' => null,
                'numeroTelephone' => '012345678' . $i,
                'sexe' => $i % 2 == 0 ? 'Masculin' : 'Féminin',
                'niveau_id' => Niveau::inRandomOrder()->first()->id,
                'filiere_id' => Filiere::inRandomOrder()->first()->id,
                'specialite_id' => Specialite::inRandomOrder()->first()->id,
                'annee_id' => 1, // ID de l'année académique à adapter selon vos besoins
            ]);
        }
    }
}
