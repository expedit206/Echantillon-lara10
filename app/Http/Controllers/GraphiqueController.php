<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Annee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GraphiqueController extends Controller
{
    public function index()
    {
        $annees = Annee::withCount(['etudiants', 'enseignants', 'uniteValeurs'])->get();
        $totalEtudiants = $annees->sum('etudiants_count');
        $totalEnseignants = $annees->sum('enseignants_count');
        $totalUnites = $annees->sum('unite_valeurs_count');


        $data = [
            'labels' => $annees->pluck('nom'),
            'etudiants' => $annees->pluck('etudiants_count'),
            'enseignants' => $annees->pluck('enseignants_count'),
            'uniteValeurs' => $annees->pluck('unite_valeurs_count'),
        ];
    
        return view('graphique', compact('data', 'totalEtudiants', 'totalEnseignants', 'totalUnites'));
    }
    


    
    public function note($annee_id)
{
    // Récupérer les taux de réussite par semestre pour les garçons
    $reussiteGarcons = Note::join('etudiants', 'notes.etudiant_id', '=', 'etudiants.id')
        ->join('unite_de_valeurs', 'notes.unite_valeur_id', '=', 'unite_de_valeurs.id')
        ->join('semestres', 'unite_de_valeurs.semestre_id', '=', 'semestres.id')
        ->where('etudiants.sexe', 'Masculin')
        ->where('semestres.annee_id', $annee_id)
        ->select('semestres.nom', DB::raw('COUNT(CASE WHEN notes.note >= 10 THEN 1 END) / COUNT(*) * 100 AS taux_reussite'))
        ->groupBy('semestres.nom')
        ->pluck('taux_reussite', 'semestres.nom');
        // dump($reussiteGarcons);

    // Récupérer les taux de réussite par semestre pour les filles
    $reussiteFilles = Note::join('etudiants', 'notes.etudiant_id', '=', 'etudiants.id')
        ->join('unite_de_valeurs', 'notes.unite_valeur_id', '=', 'unite_de_valeurs.id')
        ->join('semestres', 'unite_de_valeurs.semestre_id', '=', 'semestres.id')
        ->where('etudiants.sexe', 'Femme')
        ->where('semestres.annee_id', $annee_id)
        ->select('semestres.nom', DB::raw('COUNT(CASE WHEN notes.note >= 10 THEN 1 END) / COUNT(*) * 100 AS taux_reussite'))
        ->groupBy('semestres.nom')
        ->pluck('taux_reussite', 'semestres.nom');
        // dump($reussiteFilles);

    // Calculer le taux de réussite global par semestre
    $reussiteGlobaleSemestre = Note::join('etudiants', 'notes.etudiant_id', '=', 'etudiants.id')
        ->join('unite_de_valeurs', 'notes.unite_valeur_id', '=', 'unite_de_valeurs.id')
        ->join('semestres', 'unite_de_valeurs.semestre_id', '=', 'semestres.id')
        ->where('semestres.annee_id', $annee_id)
        ->select('semestres.nom', DB::raw('COUNT(CASE WHEN notes.note >= 10 THEN 1 END) / COUNT(*) * 100 AS taux_reussite'))
        ->groupBy('semestres.nom')
        ->pluck('taux_reussite', 'semestres.nom');
        
        // dump($reussiteGlobaleSemestre);
        // $reussiteGlobaleSemestre = 
    // Calculer le taux de réussite global pour l'année entière
    $reussiteGlobaleAnnee = [
        'Garçons' => $reussiteGarcons->avg(),
        'Filles' => $reussiteFilles->avg(),
        'Global' => $reussiteGlobaleSemestre->avg()
    ];
$annee= Annee::find($annee_id)->nom;
        // dd($reussiteGlobaleAnnee);

    return view('noteGraphique', compact('annee','reussiteGarcons', 'reussiteFilles', 'reussiteGlobaleSemestre', 'reussiteGlobaleAnnee'));
}
    
}
