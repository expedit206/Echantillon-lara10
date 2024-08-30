<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\Niveau;
use App\Models\Filiere;
use App\Models\Semestre;
use App\Models\Enseignant;
use App\Models\Specialite;
use App\Models\UniteValeur;
use Illuminate\Http\Request;
use App\Services\DataService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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


        // array_merge([
        //     'search' => $search,
        //     'total' => $total,
        //     'students' => $students,
        //     'filieres' => $filieres,
        // ], $data));
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
