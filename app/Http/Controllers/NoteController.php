<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Annee;
use App\Models\Etudiant;
use App\Models\Semestre;
use App\Models\Specialite;
use App\Models\UniteValeur;
use Illuminate\Http\Request;
use App\Services\DataService;
use App\Http\Controllers\Controller;

class NoteController extends Controller
{

    protected $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }
    public function index(Request $request)
    {


        $data = $this->dataService->getAllData();
        $semestre_id = $request->semestre;
        $specialite_id = $request->specialite;
        $unite_de_valeur_id = $request->matieres;
        $niveau_id = $request->niveau;
        $annee_id = $request->annee;
        // Filtrer les étudiants avec les critères spécifiques
        $students = Etudiant::where('annee_id', $annee_id)
        ->where('specialite_id',$specialite_id)
        ->whereRelation('uniteValeurs','unite_valeur_id', $unite_de_valeur_id)
        ->whereRelation('notes.uniteValeur', 'niveau_id', $niveau_id)
        ->whereRelation('notes.uniteValeur', 'id', $unite_de_valeur_id)
        ->whereRelation('notes.uniteValeur', 'semestre_id', $semestre_id)
        ->whereRelation('notes.uniteValeur', 'specialite_id', $specialite_id)

         ->paginate(30);
        // foreach ($students as $student ) {
        //     echo('<br>'.$student->id);
        // }
        $semestre = Semestre::find($semestre_id);
        $annee_academique = $semestre->annee->nom ?? 'Année académique non spécifiée';

        return view('note.index',array_merge([
            'students' => $students,
            'semestre' => $semestre,
            'annee_academique' => $annee_academique,
        ], $data));
    }

    public function getSemestres($annee)
{
    $semestres = Semestre::where('annee_id', $annee)->get();
    return response()->json($semestres);
}

public function getSpecialites($niveau)
{
    $specialites = Specialite::whereRelation('filiere', 'niveau_id', $niveau)->get();
    return response()->json($specialites);
}

public function getMatieresBySpecialite($specialite)
{
    $matieres = UniteValeur::where('specialite_id', $specialite)->get();
    return response()->json($matieres);
}


public function afficherReleve($etudiantId, $anneeId)
{
    $etudiant = Etudiant::findOrFail($etudiantId);
    $semestres = Semestre::where('annee_id', $anneeId)->get();
    
    $releve = [];

    foreach ($semestres as $semestre) {
        $matieres = UniteValeur::where('semestre_id', $semestre->id)->get();
        
        foreach ($matieres as $matiere) {
            $noteFinale = $this->calculerNoteFinale($etudiantId, $matiere->id, $semestre->id);
            $releve[$semestre->nom][$matiere->nom] = $noteFinale;
        }
    }
    
    return view('note.releve', compact('etudiant', 'releve'));
}

public function telechargerRelevePDF($etudiantId, $anneeId)
{
    $etudiant = Etudiant::findOrFail($etudiantId);
    $semestres = Semestre::where('annee_id', $anneeId)->get();
    // dd($semestres);
    $releve = [];

    foreach ($semestres as $semestre) {
        $matieres = UniteValeur::where('semestre_id', $semestre->id)->get();
        
        foreach ($matieres as $matiere) {
            $noteFinale = $this->calculerNoteFinale($etudiantId, $matiere->id, $semestre->id);
            $releve[$semestre->nom][$matiere->nom] = $noteFinale;
        }
    }

    $pdf = Pdf::loadView('releve_pdf', compact('etudiant', 'releve'));
    return $pdf->download('releve_notes.pdf');
}

private function calculerNoteFinale($etudiantId, $matiereId, $semestreId)
{
    $controleContinu = Note::where('etudiant_id', $etudiantId)
                            ->where('unite_valeur_id', $matiereId)
                            ->whereRelation('unite_valeur', 'semestre_id', $semestreId)
                            ->where('type', 'controle_continu')
                            ->value('note');
                            
    $sessionNormale = Note::where('etudiant_id', $etudiantId)
                            ->where('unite_valeur_id', $matiereId)
                            ->whereRelation('unite_valeur','semestre_id', $semestreId)
                            ->where('type', 'session_normale')
                            ->value('note');

    if ($controleContinu === null || $sessionNormale === null) {
        return null; // Ou une autre valeur par défaut
    }

    $noteFinale = ($controleContinu * 0.3) + ($sessionNormale * 0.7);
    
    return $noteFinale;
}


}
