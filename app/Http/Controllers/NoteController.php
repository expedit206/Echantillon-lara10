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

public function getMatieresBySpecialite($semestre,$specialite)
{

    $matieres = UniteValeur::
    where('specialite_id', $specialite)
    ->where('semestre_id', $semestre)
    ->get();
    return response()->json($matieres);
}

public function getMatieresBySemestre($specialite,$semestre)
{
    $matieres = UniteValeur::
    where('semestre_id', $semestre)
    ->where('specialite_id',$specialite)
    ->get();
    return response()->json($matieres);
}



public function showReleveDeNotes($etudiantId, $anneeAcademique)
{
    $etudiant = Etudiant::with('filiere', 'specialite', 'niveau', 'specialite.uniteValeurs')
        ->findOrFail($etudiantId);

    $matieres = $etudiant->specialite->matieres;

    $notes = [
        'semestre1' => $this->getNotesForSemestre($etudiant, 'Semestre 1'),
        'semestre2' => $this->getNotesForSemestre($etudiant, 'Semestre 2'),
    ];
    $anneeAcademique=Annee::find($anneeAcademique)->nom;
    return view('note.releve', compact('etudiant', 'notes', 'anneeAcademique', 'matieres'));
}

private function getNotesForSemestre($etudiant, $semestreNom)
{
    $notesSemestre = $etudiant->notes->filter(function ($note) use ($semestreNom) {
        return $note->uniteValeur->semestre->nom == $semestreNom;
    });
    $notesByUV = [];

    $uniteValeursSemestre = $etudiant->specialite->uniteValeurs->filter(function($uv) use ($semestreNom) {
        return $uv->semestre->nom == $semestreNom;
    });

    foreach ($uniteValeursSemestre as $matiere) {
        $controleContinuNote = $notesSemestre->where('unite_valeur_id', $matiere->id)
        ->where('type', 'Controle continu')
        ->first();
        // dump($matiere);

        $sessionNormaleNote = $notesSemestre->where('unite_valeur_id', $matiere->id)
        ->where('type', 'Normale')
        ->first();

        $rattrapageNote = $notesSemestre->where('unite_valeur_id', $matiere->id)
        ->where('type', 'Rattrapage')
        ->first();

        $isRattrapage = (bool) $rattrapageNote;
        $noteFinale = $rattrapageNote ? (
            $rattrapageNote->note * 0.7  +
            ($controleContinuNote ? $controleContinuNote->note * 0.3 : 0)
        ) : (
            ($controleContinuNote ? $controleContinuNote->note * 0.3 : 0) +
            ($sessionNormaleNote ? $sessionNormaleNote->note * 0.7 : 0)
        );
        // dd($noteFinale);

        $notesByUV[] = [
            'code' => $matiere->code,
            'nom' => $matiere->nom,
            'note' => $noteFinale,
            'credit' => $matiere->credit,
            'appreciation' => $this->getAppreciation($noteFinale),
            'session' => $this->getSessionDate($semestreNom,$isRattrapage),
            'semestre' =>Semestre::where('nom', $semestreNom)->first()->id
        ];
    }
    // die;
    return $notesByUV;
}


private function getAppreciation($note)
{
    if ($note >= 16) return 'Très bien';
    if ($note >= 14) return 'Bien';
    if ($note >= 12) return 'Assez bien';
    if ($note >= 10) return 'Passable';
    return 'Insuffisant';
}

private function getSessionDate($semestreNom, $rattrapage)
{
    $session = $semestreNom === 'Semestre 1' ? 'Mars-' : 'Juil-';
    $session .= date('Y');

    if ($rattrapage) {
        $session = '<strong>R/</strong>' . $session;
    }

    return $session;
}


}
