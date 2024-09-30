<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Annee;
use App\Models\Niveau;
use App\Models\Filiere;
use App\Models\Etudiant;
use App\Models\Semestre;
use App\Models\Enseignant;
use App\Models\Specialite;
use App\Models\UniteValeur;
use Illuminate\Http\Request;
use App\Services\DataService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EnseignantController extends Controller
{
    protected $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    public function index(Request $request)
{
    $query = Enseignant::query();

    // Appliquer les filtres si présents
    if ($request->filled('search')) {
        $query->where('nom', 'like', '%' . $request->search . '%')
              ->orWhere('prenom', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('niveau')) {
        $query->whereHas('niveaux', function ($q) use ($request) {
            $q->where('id', $request->niveau);
        });
    }
    
    if ($request->filled('filiere')) {
        $query->whereHas('filieres', function ($q) use ($request) {
            $q->where('id', $request->filiere);
        });
    }
    
    if ($request->filled('specialite')) {
        $query->whereHas('specialites', function ($q) use ($request) {
            $q->where('id', $request->specialite);
        });
    }
    
    if ($request->filled('uniteValeur')) {
        $query->whereHas('unitesValeur', function ($q) use ($request) {
            $q->where('id', $request->uniteValeur);
        });
    }
    $teachers = $query->paginate(10);
    $total = $teachers->total();

    if ($request->ajax()) {
        return view('admin.teachers', array_merge($this->dataService->getAllData(),  compact('teachers', 'total'))); // Créez une vue partielle si nécessaire
    }

    return view('admin.teachers', array_merge($this->dataService->getAllData(),  compact('teachers', 'total')));
}



            public function dashboard()
        {
            // Obtenir l'enseignant connecté
            $enseignant = Auth::guard('enseignant')->user();

            $annee_id=\DB::table('annees')->where('is_active', true)->first()->id;
            // Statistiques globales pour l'enseignant
            // dd($enseignant->niveau_id);
            $totalEtudiants = Etudiant::where('annee_id', $annee_id)
            // ->where('niveau_id',$enseignant->niveaux->pluck('id'))
            // ->where('filiere_id', $enseignant->filieres->pluck('id'))
            // ->where('specialite_id', $enseignant->specialites->pluck('id'))
            ->count();
            // Total des cours donnés par cet enseignant
            // dd($totalEtudiants);
            $totalCours = UniteValeur::where('annee_id', $annee_id)
            ->whereRelation('enseignants', 'enseignant_id', $enseignant?->id)->count();

            // Statistiques par cours
            $cours = UniteValeur::where('annee_id', $annee_id)
            ->whereRelation('enseignants', 'enseignant_id', $enseignant?->id)
                          ->withCount('etudiants')
                          ->get()
                          ->map(function ($cour) {
                              $cour->reussite = $this->calculateReussite($cour); // Assurez-vous d'avoir une méthode pour calculer la réussite
                              return $cour;
                          });
                          $annee=Annee::where('is_active',true)->first()-> nom;

            return view('enseignant.dashboard', compact('totalEtudiants', 'annee','totalCours', 'cours'));
        }

        private function calculateReussite($cours)
        {
            // logique a change
            // Implémentez la logique pour calculer le taux de réussite
            // Par exemple, basé sur les notes des étudiants
            $totalEtudiants = $cours->etudiants_count;
            $etudiantsReussis = \DB::table('notes')
            ->where('unite_valeur_id', $cours->id)
            ->where('note', '>=', 10) // Seuil de réussite, ajustez selon vos critères
            ->distinct('etudiant_id') // Compte les étudiants uniques ayant réussi
            ->count();
            // ->get();
            // dd($etudiantsReussis);
            return $totalEtudiants > 0 ? round(($etudiantsReussis / $totalEtudiants) * 100) : 0;
    }
    public function graphique($uniteValeur)
    {
        $annee_id=\DB::table('annees')->where('is_active', true)->first()->id;


        // Récupérer le cours par ID
        $cours = UniteValeur::findOrFail($uniteValeur);


        // Calculer le taux de réussite pour chaque semestre et chaque type d'évaluation
        $semestre = Semestre::where('annee_id', $annee_id)
        ->whereRelation('uniteValeurs', 'id',$uniteValeur)->first();
        $tauxReussite = [];

        // Récupérer les notes des étudiants pour ce cours
        $notes = Note::whereRelation('uniteValeur', 'annee_id', $annee_id)
        ->where('unite_valeur_id', $uniteValeur);

        // Notes pour le semestre actuel
        // dd($notes->get());
        // $notesSemestre = $notes->whereRelation('uniteValeur', 'semestre_id', $semestre->id);
        // dd($notesSemestre->get());

        // Calculer le taux de réussite pour chaque type d'évaluation
        $controleContinu = Note::whereRelation('uniteValeur', 'annee_id', $annee_id)
        ->where('unite_valeur_id', $uniteValeur)->where('type', 'Controle continu')->count();

        $sessionNormale = Note::whereRelation('uniteValeur', 'annee_id', $annee_id)
        ->where('unite_valeur_id', $uniteValeur)->where('type', 'Normale')->count();

        $rattrapage = Note::whereRelation('uniteValeur', 'annee_id', $annee_id)
        ->where('unite_valeur_id', $uniteValeur)->where('type', 'Rattrapage')->count();
        // dd($rattrapage);


        $reussisControlesContinu = Note::whereRelation('uniteValeur', 'annee_id', $annee_id)
        ->where('unite_valeur_id', $uniteValeur)->where('type', 'Controle continu')->where('note', '>=', 10)->count();
        $reussisSessionNormale = Note::whereRelation('uniteValeur', 'annee_id', $annee_id)
        ->where('unite_valeur_id', $uniteValeur)->where('type', 'Normale')->where('note', '>=', 10)->count();
        $reussisRattrapage = Note::whereRelation('uniteValeur', 'annee_id', $annee_id)
        ->where('unite_valeur_id', $uniteValeur)->where('type', 'Rattrapage')->where('note', '>=', 10)->count();

        $tauxReussite[$semestre->nom] = [
            'controle_continu' => $controleContinu > 0 ? ($reussisControlesContinu / $controleContinu) * 100 : 0,
            'session_normale' => $sessionNormale > 0 ? ($reussisSessionNormale / $sessionNormale) * 100 : 0,
            'rattrapage' => $rattrapage > 0 ? ($reussisRattrapage / $rattrapage) * 100 : 0
        ];
        // dd($tauxReussite);

        // Préparer les données pour le graphique
        $semestresNoms = array_keys($tauxReussite);
        $tauxCC = array_column(array_values($tauxReussite), 'controle_continu');
        $tauxSN = array_column(array_values($tauxReussite), 'session_normale');
        $tauxR = array_column(array_values($tauxReussite), 'rattrapage');
        $annee=Annee::where('is_active',true)->first()->nom;
// dd($annee);
        return view('enseignant.courGraphique', compact('cours', 'semestresNoms', 'tauxCC', 'tauxSN','tauxR'));
    }


     public function teachersByFiliere(Filiere $filiere)
     {
        $data = $this->dataService->getAllData();

         $teachers = Enseignant::where('filiere_id', $filiere->id)->latest()->paginate(15);
        $niveaux = Niveau::orderBy('created_at', 'desc')->get();
        $filieres = Filiere::orderBy('created_at', 'desc')->get();

         $total = $teachers->count();
         return view('admin.teachers',
         array_merge([
            'teachers' => $teachers,
            'total' => $total,
        ], $data));
        }

     public function teachersByNiveau(Niveau $niveau)
     {

        $data = $this->dataService->getAllData();

         $teachers = Enseignant::where('niveau_id', $niveau->id)->latest()->paginate(15);
        $niveaux = Niveau::orderBy('created_at', 'desc')->get();
        $filieres = Filiere::orderBy('created_at', 'desc')->get();

         $total = $teachers->count();
         return view('admin.teachers',array_merge([
            'teachers' => $teachers,
            'total' => $total,
        ], $data));
        }

        public function show(Enseignant $enseignant)
        {

        $data = $this->dataService->getAllData();
        $enseignant = Enseignant::find($enseignant->id );
        // die;
        return view('enseignant.show',
        array_merge([
            'enseignant' => $enseignant
        ], $data));
        }

        public function edit(Enseignant $enseignant)
        {
            $enseignant = Enseignant::find($enseignant->id );
            // die;
            return view('enseignant.show', compact('enseignant'));
        }

        public function assignMatiere()
        {
            // Récupérer tous les niveaux pour le formulaire


           return view('enseignant.assigner-matiere', array_merge([], $this->dataService->getAllData()));
        }

        public function storeAssignMatiere(Request $request)
        {
            // Valider les données du formulaire
            $validated = $request->validate([
                'enseignant_id' => 'required|exists:enseignants,id',
                'matiere_id' => 'required|exists:unite_de_valeurs,id',
                'specialite_id' => 'required|exists:specialites,id',
                'filiere_id' => 'required|exists:filieres,id', // Ajout validation filière
                'niveau_id' => 'required|exists:niveaux,id',    // Ajout validation niveau
            ]);

            // Récupérer l'enseignant, la matière, la spécialité, la filière, et le niveau
            $enseignant = Enseignant::find($validated['enseignant_id']);
            $matiere = UniteValeur::find($validated['matiere_id']);
            $specialite = Specialite::find($validated['specialite_id']);
            $filiere = Filiere::find($validated['filiere_id']);
            $niveau = Niveau::find($validated['niveau_id']);

            // Vérifier si l'enseignant est déjà assigné à cette matière avec ces conditions (spécialité, filière, niveau)
            $exists = $enseignant->uniteValeurs()
                ->wherePivot('unite_valeur_id', $matiere->id)
                ->wherePivot('specialite_id', $specialite->id)
                ->wherePivot('filiere_id', $filiere->id)
                ->wherePivot('niveau_id', $niveau->id)
                ->exists();

            if ($exists) {
                return redirect()->route('assigner-matiere.create')->with('error', 'Cette matière est déjà assignée à cet enseignant pour cette spécialité, filière, et niveau.');
            }

            // Assigner la matière à l'enseignant via la table pivot avec les relations appropriées
            $enseignant->uniteValeurs()->attach($matiere->id, [
                'specialite_id' => $specialite->id,
                'filiere_id' => $filiere->id,
                'niveau_id' => $niveau->id,
            ]);

            // Vérifier si l'enseignant n'est pas déjà assigné au niveau
            if (!$enseignant->niveaux()->where('niveau_id', $niveau->id)->exists()) {
                // Assigner le niveau à l'enseignant
                $enseignant->niveaux()->attach($niveau->id);
            }


            // Vérifier si l'enseignant n'est pas déjà assigné au niveau
            if (!$enseignant->specialites()->where('specialite_id', $specialite->id)->exists()) {
                // Assigner le specialite à l'enseignant
                $enseignant->specialites()->attach($specialite->id);
            }

            // Vérifier si l'enseignant n'est pas déjà assigné à la filière
            if (!$enseignant->filieres()->where('filiere_id', $filiere->id)->exists()) {
                // Assigner la filière à l'enseignant
                $enseignant->filieres()->attach($filiere->id);
            }

            return redirect()->route('assigner-matiere.create')->with('success', 'Matière attribuer a l\'enseignant avec assignés avec succès.');
        }



    }
