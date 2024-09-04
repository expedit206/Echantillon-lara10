<?php
namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\Matiere;
use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\UniteValeur;
use App\Http\Controllers\Controller;

class AppController extends Controller
{

    public function dashboard()
    {
        // Statistiques globales
        $totalEtudiants = Etudiant::count();
        $totalEnseignants = Enseignant::count();
        $totalUnites = UniteValeur::count();

        // Statistiques par année académique
        $annees = Annee::withCount(['etudiants', 'enseignants', 'uniteValeurs'])->get();
        // dd($annees);
        return view('dashboard', compact('totalEtudiants', 'totalEnseignants', 'totalUnites', 'annees'));
    }

}
