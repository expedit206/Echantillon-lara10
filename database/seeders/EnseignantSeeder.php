<?php

namespace Database\Seeders;

use App\Models\Niveau;
use App\Models\Specialite;
use App\Models\Filiere;
use App\Models\Enseignant;
use Illuminate\Database\Seeder;
use Database\Seeders\NiveauSeeder;
use Database\Seeders\FiliereSeeder;

class EnseignantSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Nombre d'enseignants à créer
        $nombreEnseignants = 50;

        $this->call(
            [
                NiveauSeeder::class,
                FiliereSeeder::class,
            specialiteSeeder::class,

                ]
            );
            $filieres = Filiere::all();
        $niveaux = Niveau::all();
        $specialites = Specialite::all();
        // Utilisation de la factory pour créer des enseignants
        $enseignants =Enseignant::factory($nombreEnseignants)->create();
        $enseignants->each(function ($enseignant) use ($niveaux, $filieres, $specialites) {
            $enseignant->niveaux()->attach(
                $niveaux->random(rand(1, 3))->pluck('id')->toArray()
            );

            $enseignant->filieres()->attach(
                $filieres->random(rand(1, 2))->pluck('id')->toArray()
            );

            $enseignant->specialites()->attach(
                $specialites->random(rand(1, 2))->pluck('id')->toArray()
            );
        });

        $dernierEnseignant = Enseignant::create([
            'nom' => 'AAA',
            'prenom' => 'AAAA',
            'sexe' => 'Masculin',
            'email' => 'aaa@aaa',
            'password' => \Hash::make('aaaaaaaa'),
            'dateNaiss' => '1990-01-01',
            'lieuNaiss' => 'Lieu AAA',
            'nationalite' => 'Nationalité AAA',
            'mobile' => '1234567890',
            'photo' => null,
            'profession' => 'Prof AAA',
            'diplome' => 'Diplôme AAA',
            'annee_id' => 1, // ID d'année à adapter
            'salaire' => 100000,
            'typeContrat' => 'CDI',
            'debutContrat' => '2024-01-01',
            'finContrat' => null,
        ]);

        // Attacher des niveaux, filières, et spécialités pour cet enseignant
        $dernierEnseignant->niveaux()->attach(
            $niveaux->random(rand(1, 3))->pluck('id')->toArray()
        );

        $dernierEnseignant->filieres()->attach(
            $filieres->random(rand(1, 2))->pluck('id')->toArray()
        );

        $dernierEnseignant->specialites()->attach(
            $specialites->random(rand(1, 2))->pluck('id')->toArray()
        );


        $this->call(UniteDeValeursSeeder::class);

}
}

