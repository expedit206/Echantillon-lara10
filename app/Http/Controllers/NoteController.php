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
        // dump($request);
        // Filtrer les étudiants avec les critères spécifiques
        $students = Etudiant::where('annee_id', $annee_id)
        -> whereHas('specialite', function($q)use($specialite_id, $unite_de_valeur_id){
            $q->where('specialite_id', $specialite_id)
            ->whereHas('uniteValeurs',function($q) use($unite_de_valeur_id){
                $q->where('unite_de_valeur_id', $unite_de_valeur_id);
            });
        })
        ->whereRelation('notes.uniteValeur', 'niveau_id', $niveau_id)
        ->whereRelation('notes.uniteValeur', 'id', $unite_de_valeur_id)
        ->whereRelation('notes.uniteValeur', 'semestre_id', $semestre_id)
        ->whereRelation('notes.uniteValeur', 'specialite_id', $specialite_id)

        ->paginate(30);
        // dump($students);
// dd($students);

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
        if(!$niveau){
    $specialites = Specialite::all();

}
    }
        return response()->json($specialites);
    }

public function getMatieresBySpecialite($semestre,$specialite)
{
    $enseignant=Auth::guard('enseignant')->user();
    // dd($matieres);
    // dd($enseignant, $semestre, $specialite);
    if ($enseignant) {
        $matieres = UniteValeur::
        whereHas('enseignants', function ($query) use ($enseignant) {
            $query->where('enseignant_id', $enseignant->id);
        })
        ->whereRelation('annee', 'is_active', true)
        ->get();
    }else{

        $matieres = UniteValeur::
        whereRelation('specialites','specialite_id', $specialite)
        // ->where('semestre_id', $semestre)
        // ->whereRelation('annee', 'is_active', true)

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
    // dump($request);
    // Récupérer l'enseignant connecté
    $enseignant = auth()->user();

    // Récupérer les paramètres de filtrage depuis la requête
    $annee = $request->input('annee');
    $niveau = $request->input('niveau');
    $specialite = $request->input('specialite');
    $semestre = $request->input('semestre');
    $matiere = $request->input('matieres');
    $filiere = Filiere::whereRelation('specialites', 'id', $specialite)->first()->id ?? null;
    // dump($filiere);

    // Récupérer les étudiants filtrés selon l'année, le niveau, la filière, et la spécialité
    $etudiants = Etudiant::with('notes')
    ->whereRelation('annee', 'id', $annee)
    ->where('niveau_id', $niveau)
    -> whereHas('specialite', function($q)use($specialite, $semestre){

        $q->where('specialite_id', $specialite)
        ->whereHas('uniteValeurs',function($q) use($semestre){
            $q->where('semestre_id', $semestre);
        } );
    })
    ->where('filiere_id', $filiere)
    //  -> whereHas('uniteValeurs', function($query) use($semestre){
    //     $query->whereRelation('semestre', 'semestre_id', $semestre);
    //  })
    ->paginate(20);
    // select * from etudiants where specialite_id=4 and niveau_id=1 and filiere_id=5 and annee_id=1
// dd(value)
    // Récupérer les notes des étudiants filtrés
    $notes = [];
    // dump($etudiants);
    foreach ($etudiants as $etudiant) {
        $controleContinu = $etudiant->notes()->where('type', 'Controle continu')->where('unite_valeur_id',$matiere )->first();
        $sessionNormale = $etudiant->notes()->where('type', 'Normale')->where('unite_valeur_id',$matiere )->first();
        $rattrapage = $etudiant->notes()->where('type', 'Rattrapage')->where('unite_valeur_id',$matiere )->first();

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
    // Validation des données envoyées
    $validated = $request->validate([
        'annee' => 'required|exists:annees,id',
        'semestre' => 'required|exists:semestres,id',
        'unite_valeur' => 'required|exists:unite_de_valeurs,id',
        'notes' => 'required|array',
        'notes.*.controle_continu' => 'nullable|numeric|min:0|max:20',
        'notes.*.session_normale' => 'nullable|numeric|min:0|max:20',
        'notes.*.rattrapage' => 'nullable|numeric|min:0|max:20',
    ]);
// dd(request('matieres'));
    // Parcourir chaque étudiant et enregistrer ou mettre à jour les notes
    foreach ($validated['notes'] as $etudiantId => $note) {
        // dd($etudiantId);
        // dd($note);
        // Enregistrer ou mettre à jour la note pour Contrôle Continu
        if (isset($note['controle_continu'])) {
            Note::updateOrCreate(
                [
                    'etudiant_id' => $etudiantId,
                    'unite_valeur_id' => $validated['unite_valeur'],
                    'type' => 'Controle continu'
                ],
                [
                    'note' => $note['controle_continu'],
                'unite_valeur_id'=> $validated['unite_valeur'],
                ]
            );
        }

        // Enregistrer ou mettre à jour la note pour la Session Normale
        if (isset($note['session_normale'])) {
            Note::updateOrCreate(
                [
                    'etudiant_id' => $etudiantId,
                    'unite_valeur_id' => $validated['unite_valeur'],
                    'type' => 'Normale'
                ],
                ['note' => $note['session_normale']]
            );
        }

        // Enregistrer ou mettre à jour la note pour Rattrapage
        if (isset($note['rattrapage'])) {
            Note::updateOrCreate(
                [
                    'etudiant_id' => $etudiantId,
                    'unite_valeur_id' => $validated['unite_valeur'],
                    'type' => 'Rattrapage'
                ],
                ['note' => $note['rattrapage']]
            );
        }
    }

    return redirect()->back()->with('success', 'Notes attribuées avec succès.');
}


}
