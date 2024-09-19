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

        $data = $this->dataService->getAllData();

        $teachers =Enseignant:: latest()->paginate(15);
        // dd($teachers);
        $total=$teachers->total();
            $search=$request['search'];
            $annee_id=\DB::table('annees')->where('is_active', true)->first()->id;

        //     // dd($request);
            $filiere= Filiere::where('id',$request['filiere'])->first()??  "";
            $specialite=Specialite::where('id', $request['specialite'])->first()?? "";
            $uniteValeur=UniteValeur::where('nom', $request['uniteValeur'])->first()?? "";
        // dd($uniteValeur);
            // dd($filiere->id);
        $teachers = Enseignant::orderBy('created_at', 'desc')
        ->where('annee_id', $annee_id)
        -> where(function ($query) use ($search){
              $query->where('nom','like','%' .$search. '%')
              ->orWhere('prenom','like', '%' . $search . '%')
              ->orWhere('id', 'like', '%' . $search . '%');
               })
                ->when($specialite, function($query) use ($specialite){
                    return $query->whereRelation('specialites','specialite_id', $specialite->id);
                })
                ->when($filiere, function($query) use ($filiere){
                //   dd($filiere->id);
                  return $query->whereRelation('filieres', 'filiere_id', $filiere->id);
                })
              ->when($uniteValeur, function($query) use ($uniteValeur){
                  return $query->whereRelation('uniteValeurs', 'id', $uniteValeur->id);
              })

              ->latest()->paginate(10);
            //   dd($teachers);
        $total = $teachers->count();
            $search=$request?->search;
        $filieres = Filiere::with('uniteValeurs')->orderBy('created_at', 'desc')->get();
        $specialites = Specialite::orderBy('created_at', 'desc')->get();
        $annees = Annee::orderBy('created_at', 'desc')->get();
        $uniteValeurs = UniteValeur::orderBy('created_at', 'desc')->get();

        // dd($annees);
        return view('admin.teachers', array_merge([
            'teachers' => $teachers,
            'total' => $total,
                'search' => $search,
        ], $data));
    }



            public function dashboard()
        {
            // Obtenir l'enseignant connecté
            $enseignant = Auth::guard('enseignant')->user();

            $annee_id=\DB::table('annees')->where('is_active', true)->first()->id;

            // Statistiques globales pour l'enseignant
            $totalEtudiants = Etudiant::where('annee_id', $annee_id)
            ->whereHas('uniteValeurs', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant?->id);
            })->count();
            // Total des cours donnés par cet enseignant
            $totalCours = UniteValeur::where('annee_id', $annee_id)
            ->where('enseignant_id', $enseignant?->id)->count();

            // Statistiques par cours
            $cours = UniteValeur::where('annee_id', $annee_id)
           ->where('enseignant_id', $enseignant?->id)
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
        $annee=Annee::where('is_active',true)->nom;

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
    }
