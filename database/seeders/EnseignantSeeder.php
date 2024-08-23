<?php

namespace Database\Seeders;

use App\Models\Niveau;
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
                FiliereSeeder::class
                ]
            );
            $filieres = Filiere::all();
        $niveaux = Niveau::all();

        // Utilisation de la factory pour créer des enseignants
        $enseignants =Enseignant::factory($nombreEnseignants)->create();
        $this->call(UniteDeValeursSeeder::class);
        $enseignants->each(function ($enseignant) use ($niveaux, $filieres) {
            $enseignant->niveaux()->attach(
                $niveaux->random(rand(1, 3))->pluck('id')->toArray()
            );

            $enseignant->filieres()->attach(
                $filieres->random(rand(1, 2))->pluck('id')->toArray()
            );
        });
}
}

