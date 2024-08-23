<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\Niveau;
use App\Models\Filiere;
use App\Models\Enseignant;
use App\Models\UniteValeur;
use Illuminate\Http\Request;

class EnseignantController extends Controller
{
    public function index(Request $request)
    {
        $teachers =Enseignant:: latest()->paginate(15);
        // dd($teachers);
        $total=$teachers->total();
            $search=$request['search'];
            $annee_id=\DB::table('annees')->where('is_active', true)->first()->id;

        //     // dd($request);
            $filiere= Filiere::where('id',$request['filiere'])->first()??  "";
            $niveau=Niveau::where('id', $request['niveau'])->first()?? "";
            $uniteValeur=UniteValeur::where('id', $request['uniteValeur'])->first()?? "";
        // dd($uniteValeur);
        //     // dd($filiere );
// die('n,;');
        $teachers = Enseignant::orderBy('created_at', 'desc')
        ->where('annee_id', $annee_id)
        -> where(function ($query) use ($search){
              $query->where('nom','like','%' .$search. '%')
              ->orWhere('prenom','like', '%' . $search . '%')
              ->orWhere('id', 'like', '%' . $search . '%');
               })
                ->when($niveau, function($query) use ($niveau){

                  return $query->whereRelation('niveaux','niveau_id', $niveau->id);
              })
              ->when($filiere, function($query) use ($filiere){
                  return $query->whereRelation('filieres', 'filiere_id', $filiere->id);
              })
              ->when($uniteValeur, function($query) use ($uniteValeur){
                  return $query->whereRelation('uniteValeurs', 'id', $uniteValeur->id);
              })

              ->latest()->paginate(10);
        $total = $teachers->count();
            $search=$request?->search;
        $filieres = Filiere::with('uniteValeurs')->orderBy('created_at', 'desc')->get();
        $niveaux = Niveau::orderBy('created_at', 'desc')->get();
    $annees = Annee::orderBy('created_at', 'desc')->get();
        $uniteValeurs = UniteValeur::orderBy('created_at', 'desc')->get();
        return view('admin.teachers', compact('teachers','total','niveaux','filieres','uniteValeurs','annees'));
    }
     public function teachersByFiliere(Filiere $filiere)
     {
         $teachers = Enseignant::where('filiere_id', $filiere->id)->latest()->paginate(15);
        $niveaux = Niveau::orderBy('created_at', 'desc')->get();
        $filieres = Filiere::orderBy('created_at', 'desc')->get();

         $total = $teachers->count();
         return view('admin.teachers',compact('teachers','total','niveaux','filieres'));
        }



     public function teachersByNiveau(Niveau $niveau)
     {
         $teachers = Enseignant::where('niveau_id', $niveau->id)->latest()->paginate(15);
        $niveaux = Niveau::orderBy('created_at', 'desc')->get();
        $filieres = Filiere::orderBy('created_at', 'desc')->get();

         $total = $teachers->count();
         return view('admin.teachers',compact('teachers','total','niveaux','filieres'));
        }

        public function show(Enseignant $enseignant)
        {
            $enseignant = Enseignant::find($enseignant->id );
            // die;
            return view('enseignant.show', compact('enseignant'));
        }

        public function edit(Enseignant $enseignant)
        {
            $enseignant = Enseignant::find($enseignant->id );
            // die;
            return view('enseignant.show', compact('enseignant'));
        }
    }
