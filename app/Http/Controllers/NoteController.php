<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Annee;
use App\Models\Filiere;
use App\Models\Etudiant;
use App\Models\Semestre;
use App\Models\Specialite;
use App\Models\UniteValeur;
use Illuminate\Http\Request;
use App\Services\DataService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

$enseignant=Auth::guard('enseignant')->user();
// dd($enseignant);
        if ($enseignant) {
            $semestres = Semestre::where('annee_id', $annee)
            -> whereHas('uniteValeurs', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);})
                ->get();
            }else{

                $semestres = Semestre::where('annee_id', $annee)
                ->get();
            }
    return response()->json($semestres);
}

    public function getSpecialites($niveau)
    {
        $enseignant=Auth::guard('enseignant')->user();
        // dd($enseignant);
        // dd($niveau);
        if ($enseignant) {
        $specialites = Specialite::whereRelation('filiere', 'niveau_id', $niveau)
        ->whereHas('enseignants', function ($query) use ($enseignant) {
            $query->where('enseignant_id', $enseignant->id);})
            ->get();
    }else{
        $specialites = Specialite::whereRelation('filiere', 'niveau_id', $niveau)->get();

    }
        return response()->json($specialites);
    }

public function getMatieresBySpecialite($semestre,$specialite)
{
    $enseignant=Auth::guard('enseignant')->user();
    // dd($matieres);
    // dd($enseignant, $semestre, $specialite);
    if ($enseignant) {
        // Si l'utilisateur est un enseignant, récupérer uniquement les données liées à ses unités de valeur
        $matieres = UniteValeur::whereHas('enseignants', function ($query) use ($enseignant) {
            $query->where('id', $enseignant->id);
        })
        ->whereRelation('annee', 'is_active', true)
        ->get();
    }else{

        $matieres = UniteValeur::
        whereRelation('specialites','specialite_id', $specialite)
        ->where('semestre_id', $semestre)
        ->whereRelation('annee', 'is_active', true)

        ->get();
    }
    return response()->json($matieres);
}

public function getMatieresBySemestre($specialite,$semestre)
{
    $enseignant=Auth::guard('enseignant')->user();

    if ($enseignant) {

    $semestres = Semestre::whereHas('uniteValeurs', function ($query) use ($enseignant) {
        $query->where('enseignant_id', $enseignant->id);})
        ->whereRelation('annee', 'is_active', true)

        ->get();
        // dd($semestres);
    }
    else{

        $matieres = UniteValeur::
        where('semestre_id', $semestre)
        ->whereRelation('specialites','specialite_id',$specialite)
        ->whereRelation('annee', 'is_active', true)

        ->get();
    }
    // return console.log($matieres);
    return response()->json($matieres);
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
    $session .= date('y');

    if ($rattrapage) {
        $session = '<strong>R/</strong>' . $session;
    }

    return $session;
}

public function create(Request $request)
{
    // Récupérer l'enseignant connecté
    $enseignant = auth()->user();

    // Récupérer les paramètres de filtrage depuis la requête
    $annee = $request->input('annee');
    $niveau = $request->input('niveau');
    $specialite = $request->input('specialite');
    $semestre = $request->input('semestre');
    $matiere = $request->input('matieres');
    $filiere = Filiere::whereRelation('specialites', 'id', $specialite)->first()->id;

    // Récupérer les étudiants filtrés selon l'année, le niveau, la filière, et la spécialité
    $etudiants = Etudiant::with('notes')
    ->whereRelation('annee', 'id', $annee)
    ->where('niveau_id', $niveau)
    ->where('specialite_id', $specialite)
    ->where('filiere_id', $filiere)
     -> whereHas('uniteValeurs', function($query) use($semestre){
        $query->whereRelation('semestre', 'semestre_id', $semestre);
     })
    ->get();
    // select * from etudiants where specialite_id=4 and niveau_id=1 and filiere_id=5 and annee_id=1
// dd(value)
    // Récupérer les notes des étudiants filtrés
    $notes = [];
    foreach ($etudiants as $etudiant) {
        $controleContinu = $etudiant->notes()->where('type', 'Controle continu')->first();
        $sessionNormale = $etudiant->notes()->where('type', 'Normale')->first();
        $rattrapage = $etudiant->notes()->where('type', 'Rattrapage')->first();

        // Calcul de la moyenne
        $moyenne = 0;
        if ($controleContinu && $sessionNormale) {
            $moyenne = ($controleContinu->note + $sessionNormale->note) / 2;
        }

        $notes[] = [
            'id' => $etudiant->id,
            'nom' => $etudiant->nom,
            'prenom' => $etudiant->prenom,
            'controle_continu' => $controleContinu ? $controleContinu->note : null,
            'session_normale' => $sessionNormale ? $sessionNormale->note : null,
            'rattrapage' => $rattrapage ? $rattrapage->note : null,
            'moyenne' => $moyenne,
        ];
    }
    $totalEtudiant = $etudiants->count();


    // Passer les données à la vue
    return view('note.assign', array_merge($this->dataService->getAllData(), compact('etudiants', 'notes','totalEtudiant')));
}



public function store(Request $request)
{
    $validated = $request->validate([
        'annee' => 'required|exists:annees,id',
        'semestre' => 'required|exists:semestres,id',
        'matiere' => 'required|exists:matieres,id',
        'notes' => 'required|array',
        'notes.*' => 'numeric|min:0|max:20',
    ]);

    // Enregistrez les notes
    foreach ($validated['notes'] as $etudiantId => $note) {
        Note::updateOrCreate(
            ['etudiant_id' => $etudiantId, 'matiere_id' => $validated['matiere']],
            ['note' => $note]
        );
    }

    return redirect()->route('notes.create')->with('success', 'Notes attribuées avec succès.');
}



}
