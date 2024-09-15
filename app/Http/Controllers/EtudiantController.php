<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\Niveau;
use App\Models\Filiere;
use App\Models\Etudiant;
use App\Models\Specialite;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\DataService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class EtudiantController extends Controller
{
    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    public function index(Request $request)
{
    $annee_id = Annee::where('is_active', true)->first()->id;

    // Si un enseignant est connecté
    if (Auth::guard('enseignant')->check()) {
      
        $enseignantData = $this->getStudentsForEnseignant(Auth::guard('enseignant')->user(), $annee_id,$request);
        $students = $enseignantData['students'];
        $total = $enseignantData['total'];
    } else {
        // Si un administrateur est connecté
        $students = $this->getStudentsForAdmin($annee_id, $request);
        // $total=$students->count();
    }

    // Récupérer les filtres pour les recherches
    $search = $request->input('search');
    $filieres = Filiere::latest()->get();
    $niveaux = Niveau::latest()->get();
    $specialites = Specialite::latest()->get();
    $annees = Annee::all();

    return view('admin.students', array_merge([
        'search' => $search,
        'students' => $students,
        'total' => $total,
    ], $this->dataService->getAllData()));
}


private function getStudentsForEnseignant($enseignant,$annee_id, Request $request)
{
    $students = collect();
    $page = $request->input('page', 1);
    $perPage = 12;
    foreach ($enseignant->specialites as $specialite) { 
        $query = Etudiant::where('annee_id', $annee_id)
        ->where('specialite_id', $specialite->id) ;
        $query = $query->where('specialite_id', $specialite->id);
        $filteredQuery = $this->applyFilters($query, $request);
        
        // dump($filteredQuery->get());
        $students = $students->merge($filteredQuery->get());
        // dump($students);
    }

    $total= $students->count();
    dump($total);
    
    $items = $students->forPage($page, $perPage);

    return [
        'students' => new LengthAwarePaginator(
            $items,
            $students->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        ),
        'total' => $total
    ];
}

private function getStudentsForAdmin($annee_id, Request $request)
{
    $query = Etudiant::where('annee_id', $annee_id);

    if ($request->has('search') || $request->has('niveau') || $request->has('filiere') || $request->has('anciennete')) {
        $query = $this->applyFilters($query, $request);
    }

    return $query->latest()->paginate(10);
}

private function applyFilters($query, Request $request)
{
    $search = $request->input('search');
    $niveau = Niveau::where('nom', $request->input('niveau'))->first();
    $filiere = Filiere::where('nom', $request->input('filiere'))->first();
    $specialite = Specialite::find($request->input('specialite'));

    // Recherche par mot-clé
    $query->where(function ($q) use ($search) {
        $q->where('nom', 'like', '%' . $search . '%')
          ->orWhere('prenom', 'like', '%' . $search . '%')
          ->orWhere('code', 'like', '%' . $search . '%');
    });

    // Filtre par niveau, filière et spécialité
    if ($niveau) {
        $query->where('niveau_id', $niveau->id);
    }

    if ($filiere) {
        $query->where('filiere_id', $filiere->id);
    }

    if ($specialite) {
        $query->where('specialite_id', $specialite->id);
    }

    // Tri en fonction de l'ancienneté
    $anciennete = $request->input('anciennete');
    if ($anciennete === 'Plus recent') {
        $query->orderBy('id', 'desc');
    } elseif ($anciennete === 'Moins recent') {
        $query->orderBy('id', 'asc');
    } elseif ($anciennete === 'A à Z') {
        $query->orderBy('nom', 'asc');
    } elseif ($anciennete === 'Z à A') {
        $query->orderBy('nom', 'desc');
    }

    return $query;
}

    

     public function home()
    {
        $data = $this->dataService->getAllData();

   return view('etudiant.home', $data);
    }
     public function show(Etudiant $student)
     {
        $data = $this->dataService->getAllData();

         // Récupération de l'enseignant avec ses relations
         $student = Etudiant::findOrFail($student->id);

         return view('etudiant.show',  array_merge([
            'student' => $student,
        ], $data));
     }


     public function studentsByFiliere(Filiere $filiere)
     {
        $data = $this->dataService->getAllData();


         $students = Etudiant::where('filiere_id', $filiere->id)->latest()->paginate(15);
        $niveaux = Niveau::orderBy('created_at', 'desc')->get();
        $filieres = Filiere::orderBy('created_at', 'desc')->get();

         $total = $students->count();
         return view('admin.students',    array_merge([
            'total' => $total,
            'students' => $students,
            'filieres' => $filieres,
        ], $data));
    }



     public function studentsByNiveau(Niveau $niveau)
     {
        $data = $this->dataService->getAllData();

         $students = Etudiant::where('niveau_id', $niveau->id)->latest()->paginate(15);
        $niveaux = Niveau::orderBy('created_at', 'desc')->get();
        $filieres = Filiere::orderBy('created_at', 'desc')->get();

         $total = $students->count();
         return view('admin.students',     array_merge([
            'total' => $total,
            'students' => $students,
            'filieres' => $filieres,
        ], $data));
        }
}
