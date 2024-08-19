<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enseignant;

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

        // Utilisation de la factory pour créer des enseignants
        Enseignant::factory($nombreEnseignants)->create();
    }
}
