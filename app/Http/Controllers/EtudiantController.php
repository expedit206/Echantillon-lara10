<?php

namespace App\Http\Controllers;

use App\Models\Niveau;
use App\Models\Filiere;
use App\Models\Etudiant;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    public function index(Request $request)
    {

        $students = Etudiant::latest()->paginate(15);
// dd($request);
        if($request['search'] || $request['niveau'] || $request['filiere'] || $request['anciennete']){
            $search=$request['search'];
            // dd($request);
            $filiere= Filiere::where('nom',$request['filiere'])->first()??  "";
            $niveau=Niveau::where('nom', $request['niveau'])->first()?? "";

            // dd($filiere );
            $anciennete=$request['anciennete'];
// dd($filiere->nom);
            switch($anciennete){
                case 'Plus recent':
                    // dd($filiere );
                    $students = Etudiant::orderBy('created_at', 'desc')
                  -> where(function ($query) use ($search){
                        $query->where('nom','like','%' .$search. '%')
                        ->orWhere('prenom','like', '%' . $search . '%')
                        ->orWhere('code', 'like', '%' . $search . '%');
                         })
                          ->when($niveau, function($query) use ($niveau){

                            return $query->where('idNiveau', $niveau->id);
                        })
                        ->when($filiere, function($query) use ($filiere){

                            return $query->where('idFiliere', $filiere->id);
                        })

                        ->latest()->paginate(10);
                        break;
                case 'Moins recent':

                    $students = Etudiant::orderBy('created_at', 'asc')
                  -> where(function ($query) use ($search){
                        $query->where('nom','like','%' .$search. '%')
                        ->orWhere('prenom','like', '%' . $search . '%')
                        ->orWhere('code', 'like', '%' . $search . '%');
                         })
                         ->when($niveau, function($query) use ($niveau){

                            return $query->where('idNiveau', $niveau->id);
                        })
                        ->when($filiere, function($query) use ($filiere){

                            return $query->where('idFiliere', $filiere->id);
                        })

                        ->latest()->paginate(10);
                        break;

                        case 'Moins recent':
                            $students = Etudiant::orderBy('created_at', 'asc')
                          -> where(function ($query) use ($search){
                                $query->where('nom','like','%' .$search. '%')
                                ->orWhere('prenom','like', '%' . $search . '%')
                                ->orWhere('code', 'like', '%' . $search . '%');
                                 })
                                 ->when($niveau, function($query) use ($niveau){

                                    return $query->where('idNiveau', $niveau->id);
                                })
                                ->when($filiere, function($query) use ($filiere){

                                    return $query->where('idFiliere', $filiere->id);
                                })
                                ->latest()->paginate(10);
                        break;

             }
        //     $anciennete=="moins recent" ? orderBy('created_at', 'asc'):"";
        // $anciennete=="A à Z" ? orderBy('nom', 'asc'):"";
        // $anciennete=="Z à A" ? orderBy('nom', 'desc'):"";
        //     if($anciennete=="moins recent"){orderBy('created_at', 'asc');};
        // if($anciennete=="A à Z"){orderBy('nom', 'asc');};
        // if($anciennete=="Z à A"){orderBy('nom', 'desc');};

                            }

            $total = $students->count();
            $search=$request?->search;

        $filieres = Filiere::orderBy('created_at', 'desc')->get();
        $niveaux = Niveau::orderBy('created_at', 'desc')->get();
        return view('admin.students', compact('students','total','search','niveaux','filieres'));
     }

     public function studentsByFiliere(Filiere $filiere)
     {

         $students = Etudiant::where('idFiliere', $filiere->id)->latest()->paginate(15);
        $niveaux = Niveau::orderBy('created_at', 'desc')->get();
        $filieres = Filiere::orderBy('created_at', 'desc')->get();

         $total = $students->count();
         return view('admin.students',compact('students','total','niveaux','filieres'));
        }



     public function studentsByNiveau(Niveau $niveau)
     {
         $students = Etudiant::where('idNiveau', $niveau->id)->latest()->paginate(15);
        $niveaux = Niveau::orderBy('created_at', 'desc')->get();
        $filieres = Filiere::orderBy('created_at', 'desc')->get();

         $total = $students->count();
         return view('admin.students',compact('students','total','niveaux','filieres'));
        }
}
