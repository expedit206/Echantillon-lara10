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
        $this->call(UniteDeValeursSeeder::class);

}
}

