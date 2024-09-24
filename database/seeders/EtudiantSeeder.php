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
        $nombreEtudiants = 100;

        // Création des étudiants via la factory
        $etudiants = Etudiant::factory($nombreEtudiants)->create();

        // Insérer un dernier étudiant spécifique avec email et mot de passe
        $dernierEtudiant = Etudiant::create([
            'matricule' => 'ETD001',
            'nom' => 'AAA',
            'prenom' => 'AAAA',
            'email' => 'aaa@aaa',
            'password' => \Hash::make('aaaaaaaa'),
            'dateNaissance' => '2000-01-01',
            'lieuNaiss' => 'Lieu AAA',
            'photo' => null,
            'numeroTelephone' => '0123456789',
            'sexe' => 'Masculin',
            'niveau_id' => Niveau::inRandomOrder()->first()->id,
            'filiere_id' => Filiere::inRandomOrder()->first()->id,
            'specialite_id' => Specialite::inRandomOrder()->first()->id,
            'annee_id' => 1, // ID de l'année académique à adapter selon vos besoins
        ]);
    }
}
