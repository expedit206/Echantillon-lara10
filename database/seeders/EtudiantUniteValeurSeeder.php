<?php

namespace Database\Seeders;

use App\Models\Etudiant;
use App\Models\UniteValeur;
use Illuminate\Database\Seeder;
use App\Models\EtudiantUniteValeur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EtudiantUniteValeurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Récupérer tous les étudiants
        $etudiants = Etudiant::all();

        foreach ($etudiants as $etudiant) {
            // Récupérer la spécialité de l'étudiant
            $specialite_id = $etudiant->specialite_id;

            // Récupérer les unités de valeur associées à la spécialité de l'étudiant
            $unitesValeur = UniteValeur::where('specialite_id', $specialite_id)->get();

            // Assigner une ou plusieurs unités de valeur à l'étudiant
            foreach ($unitesValeur as $uniteValeur) {
                // Vérifier si l'unité de valeur est déjà attribuée à l'étudiant pour éviter les doublons
                $alreadyAssigned = EtudiantUniteValeur::where('etudiant_id', $etudiant->id)
                    ->where('unite_valeur_id', $uniteValeur->id)
                    ->exists();

                if (!$alreadyAssigned) {
                    EtudiantUniteValeur::create([
                        'etudiant_id' => $etudiant->id,
                        'unite_valeur_id' => $uniteValeur->id,
                    ]);
                }
            }
        }}
}
