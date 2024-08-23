<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\Niveau;
use App\Models\Filiere;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EtudiantController extends Controller
{
    public function index(Request $request)
    {
        $annee_id=Annee::where('is_active',true)->first()->id;
        $students = Etudiant::where('annee_id',$annee_id)->latest()->paginate(15);
// dd($request);
        if($request['search'] || $request['niveau'] || $request['filiere'] || $request['anciennete']){
            $search=$request['search'];
            $annee_id=\DB::table('annees')->where('is_active', true)->first()->id;


            // dd($annee_id);
            $filiere= Filiere::where('nom',$request['filiere'])->first()??  "";
            $niveau=Niveau::where('nom', $request['niveau'])->first()?? "";

            // dd($filiere );
            $anciennete=$request['anciennete'];
            switch($anciennete){
                case 'Plus recent':
                    // dd($annee_id );
                    $students = Etudiant::orderBy('id', 'desc')
                    ->where('annee_id', $annee_id)

                  -> where(function ($query) use ($search){
                        $query->where('nom','like','%' .$search. '%')
                        ->orWhere('prenom','like', '%' . $search . '%')
                        ->orWhere('code', 'like', '%' . $search . '%');
                         })
                          ->when($niveau, function($query) use ($niveau){

                            return $query->where('niveau_id', $niveau->id);
                        })
                        ->when($filiere, function($query) use ($filiere){

                            return $query->where('filiere_id', $filiere->id);
                        })


                        ->latest()->paginate(10);
                        break;
                case 'Moins recent':

                    $students = Etudiant::orderBy('id', 'asc')
                    ->where('annee_id', $annee_id)

                  -> where(function ($query) use ($search){
                        $query->where('nom','like','%' .$search. '%')
                        ->orWhere('prenom','like', '%' . $search . '%')
                        ->orWhere('code', 'like', '%' . $search . '%');
                         })
                         ->when($niveau, function($query) use ($niveau){

                            return $query->where('niveau_id', $niveau->id);
                        })
                        ->when($filiere, function($query) use ($filiere){

                            return $query->where('filiere_id', $filiere->id);
                        })


                        ->latest()->paginate(10);
                        break;

                     case 'A à Z':
                            $students = Etudiant::orderBy('nom', 'asc')
                    ->where('annee_id', $annee_id)

                          -> where(function ($query) use ($search){
                                $query->where('nom','like','%' .$search. '%')
                                ->orWhere('prenom','like', '%' . $search . '%')
                                ->orWhere('code', 'like', '%' . $search . '%');
                                 })
                                 ->when($niveau, function($query) use ($niveau){

                                    return $query->where('niveau_id', $niveau->id);
                                })
                                ->when($filiere, function($query) use ($filiere){

                                    return $query->where('filiere_id', $filiere->id);
                                })
                                ->latest()->paginate(10);
                        break;
                     case 'Z à A':
                            $students = Etudiant::orderBy('nom', 'desc')
                    ->where('annee_id', $annee_id)

                          -> where(function ($query) use ($search){
                                $query->where('nom','like','%' .$search. '%')
                                ->orWhere('prenom','like', '%' . $search . '%')
                                ->orWhere('code', 'like', '%' . $search . '%');
                                 })
                                 ->when($niveau, function($query) use ($niveau){

                                    return $query->where('niveau_id', $niveau->id);
                                })
                                ->when($filiere, function($query) use ($filiere){

                                    return $query->where('filiere_id', $filiere->id);
                                })
                                ->latest()->paginate(10);
                        break;

             }


                            }

            $total = $students->count();
            $search=$request?->search;

        $filieres = Filiere::orderBy('created_at', 'desc')->get();
        $niveaux = Niveau::orderBy('created_at', 'desc')->get();
        $annees = Annee::all();
        // dd($students->niveau);
        return view('admin.students', compact('students','total','search','niveaux','filieres','annees'));
     }

     public function home()
    {
   return view('etudiant.home');
    }
     public function show(Etudiant $student)
     {
         // Récupération de l'enseignant avec ses relations
         $student = Etudiant::findOrFail($student->id);

         return view('etudiant.show', compact('student'));
     }


     public function studentsByFiliere(Filiere $filiere)
     {

         $students = Etudiant::where('filiere_id', $filiere->id)->latest()->paginate(15);
        $niveaux = Niveau::orderBy('created_at', 'desc')->get();
        $filieres = Filiere::orderBy('created_at', 'desc')->get();

         $total = $students->count();
         return view('admin.students',compact('students','total','niveaux','filieres'));
        }



     public function studentsByNiveau(Niveau $niveau)
     {
         $students = Etudiant::where('niveau_id', $niveau->id)->latest()->paginate(15);
        $niveaux = Niveau::orderBy('created_at', 'desc')->get();
        $filieres = Filiere::orderBy('created_at', 'desc')->get();

         $total = $students->count();
         return view('admin.students',compact('students','total','niveaux','filieres'));
        }
}
